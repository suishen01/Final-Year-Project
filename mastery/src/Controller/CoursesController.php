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

    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
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
        $this->set('course', $course);
        $this->set('_serialize', ['course']);

        if ($this->Auth->user()['role'] == 'Student') {
          $nodes = [];
          foreach ($course->tests as $test){
            $array = ['id'=>$test->id, 'label'=>$test->name, 'color'=>'#00a6e5'];
            array_push($nodes, $array);
          }
          $this->loadModel('Prerequisites');
          $this->loadModel('Tests');
          $marks_total = $this->Prerequisites->find();
          $marks_total
              ->select(['Prerequisites.pre_id', 'Prerequisites.test_id', 'Prerequisites.required_marks', 'count' => $marks_total->func()->count('q.id')])
              ->where(['t.course_id =' => $id])
              ->hydrate(false)
              ->join([
                  'table' => 'tests',
                  'alias' => 't',
                  'type' => 'LEFT',
                  'conditions' => [
                      't.id = Prerequisites.pre_id'
                  ]
              ])
              ->join([
                  'table' => 'questions',
                  'alias' => 'q',
                  'type' => 'LEFT',
                  'conditions' => [
                      'q.test_id = Prerequisites.pre_id'
                  ]
              ])
              ->group('Prerequisites.pre_id')
              ->group('Prerequisites.test_id')
              ->group('Prerequisites.required_marks');

          $marks_student = $this->Prerequisites->find();
          $marks_student
              ->select(['Prerequisites.pre_id', 'Prerequisites.test_id', 'count' => $marks_student->func()->count('q.id')])
              ->where(['t.course_id =' => $id])
              ->where(['q.id = m.question_id'])
              ->where(['m.user_id =' => $this->Auth->user()['id']])
              ->hydrate(false)
              ->join([
                  'table' => 'tests',
                  'alias' => 't',
                  'type' => 'LEFT',
                  'conditions' => [
                      't.id = Prerequisites.pre_id'
                  ]
              ])
              ->join([
                  'table' => 'questions',
                  'alias' => 'q',
                  'type' => 'LEFT',
                  'conditions' => [
                      'q.test_id = Prerequisites.pre_id'
                  ]
              ])
              ->join([
                  'table' => 'marks',
                  'alias' => 'm',
                  'type' => 'LEFT',
                  'conditions' => [
                      'm.question_id = q.id'
                  ]
              ])
              ->group('Prerequisites.pre_id')
              ->group('Prerequisites.test_id');

          $edges = [];
          $edges2 = [];
          foreach($marks_total as $prereq) {
              foreach ($marks_student as $prereq2) {
                  if($prereq['pre_id'] === $prereq2['pre_id'] && $prereq['test_id'] === $prereq2['test_id']) {
                      if($prereq2['count']/$prereq['count']*100 >= $prereq['required_marks']) {
                          $array3 = ['from'=>$prereq["pre_id"],'to'=>$prereq["test_id"],'id'=>"e".$prereq["pre_id"]."-".$prereq["test_id"]];
                          array_push($edges2, $array3);
                      }
                  }
              }
          }

          foreach($marks_total as $prereq) {
            $array2 = ['from'=>$prereq["pre_id"],'to'=>$prereq["test_id"],'id'=>"e".$prereq["pre_id"]."-".$prereq["test_id"], 'label'=>$prereq['required_marks'].'%','dashes'=>"true", 'color'=>'#000000'];
            array_push($edges, $array2);
          }

          foreach ($edges as $key=>$value) {
            foreach ($edges2 as $e2) {
              if($value['id'] === $e2['id'] ) {
                $edges[$key]['dashes'] = 'false';
                $edges[$key]['label'] = '';
              }
            }
          }

          foreach ($nodes as $key=>$value){
            foreach ($edges as $e) {
              if($value['id'] === $e['to'] && $e['dashes'] === 'true') {
                $nodes[$key]['color'] = '#808080';
              }
            }
          }

          $query = $this->Tests->find();
          $query
              ->select(['Tests.id', 'count' => $query->func()->count('q.id')])
              ->where(['Tests.course_id =' => $id])
              ->hydrate(false)
              ->join([
                  'table' => 'questions',
                  'alias' => 'q',
                  'type' => 'LEFT',
                  'conditions' => [
                      'q.test_id = Tests.id'
                  ]
              ])
              ->group('Tests.id');
          $query2 = $this->Tests->find();
          $query2
              ->select(['Tests.id', 'count' => $query->func()->count('q.id')])
              ->where(['Tests.course_id =' => $id])
              ->where(['m.user_id =' => $this->Auth->user()['id']])
              ->hydrate(false)
              ->join([
                  'table' => 'questions',
                  'alias' => 'q',
                  'type' => 'LEFT',
                  'conditions' => [
                      'q.test_id = Tests.id'
                  ]
              ])
              ->join([
                  'table' => 'marks',
                  'alias' => 'm',
                  'type' => 'LEFT',
                  'conditions' => [
                      'm.question_id = q.id'
                  ]
              ])
              ->group('Tests.id');

          foreach ($nodes as $key=>$value){
            $t = false;
            foreach ($query as $q) {
              foreach ($query2 as $q2) {
                if ($q['id'] == $q2['id'] && $nodes[$key]['id'] == $q['id']) {
                  $t = true;
                  $nodes[$key]['label'] = $nodes[$key]['label']."\\n\\n(".($q2['count']/$q['count']*100)."%)";
                }
              }
            }
            if ($t == false) {
                $nodes[$key]['label'] = $nodes[$key]['label']."\\n\\n(0%)";
            }
          }

          $this->set('edges', $edges);
          $this->set('nodes', $nodes);
        } else {
          $this->render('/Courses/adminview');
        }
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
