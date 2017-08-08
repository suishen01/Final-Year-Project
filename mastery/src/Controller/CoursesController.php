<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[] paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        if (!$this->isAuthorized($this->Auth->user())) {
            throw new UnauthorizedException();
        }
    }

    public function isAuthorized($user)
    {
        if (in_array($this->request->getParam('action'), ['index'])) {
            return true;
        } else if ($this->Auth->user()['role'] != 'Admin' && in_array($this->request->getParam('action'), ['view'])){
            $this->loadModel('Enrollment');
            $query = $this->Enrollment->find()
                ->select(['Enrollment.id'])
                ->where(['Enrollment.user_id =' => $this->Auth->user()['id']])
                ->where(['Enrollment.course_id =' => $this->request->getParam('pass')['0']]);
            $enrolled = $query->toArray();
            if (!empty($enrolled)) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $courses = $this->paginate($this->Courses);

        $this->set(compact('courses'));
        $this->set('_serialize', ['courses']);
    }



    /**
     * View method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $course = $this->Courses->get($id, [
            'contain' => ['Enrollment', 'Tests']
        ]);
        $tests = [];
        foreach ($course->tests as $test){
          $array = ['id'=>$test->id, 'label'=>$test->name];
          array_push($tests, $array);
        }
        $this->loadModel('Prerequisites');

        $prereqs = [];
        $query = $this->Prerequisites->find();
        $query
            ->select(['Prerequisites.pre_id', 'Prerequisites.test_id'])
            ->where(['t.course_id =' => $id])
            ->hydrate(false)
            ->join([
                'table' => 'tests',
                'alias' => 't',
                'type' => 'LEFT',
                'conditions' => [
                    't.id = Prerequisites.pre_id'
                ]
            ]);
        foreach($query as $prereq) {
          $array2 = ['from'=>$prereq["pre_id"],'to'=>$prereq["test_id"],'id'=>"e".$prereq["pre_id"]."-".$prereq["test_id"]];
          array_push($prereqs, $array2);
        }
        
        $this->set('prereqs', $prereqs);
        $this->set('tests', $tests);
        $this->set('course', $course);
        $this->set('_serialize', ['course']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $course = $this->Courses->newEntity();
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
        }
        $this->set(compact('course'));
        $this->set('_serialize', ['course']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $course = $this->Courses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->getData());
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
        }
        $this->set(compact('course'));
        $this->set('_serialize', ['course']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $course = $this->Courses->get($id);
        if ($this->Courses->delete($course)) {
            $this->Flash->success(__('The course has been deleted.'));
        } else {
            $this->Flash->error(__('The course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
