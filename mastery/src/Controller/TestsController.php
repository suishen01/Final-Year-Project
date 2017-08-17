<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests
 *
 * @method \App\Model\Entity\Test[] paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
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
        if (($this->Auth->user()['role'] === 'Teacher') ||
          (in_array($this->request->getParam('action'), ['view']) && $this->Tests->get($this->request->getParam('pass'))['published'] === true)) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function passedPrerequisites($id, $test)
    {
        if ($this->Auth->user()['role'] === 'Student') {
            $this->loadModel('Prerequisites');
            $query = $this->Prerequisites->find();
            $query
                ->select(['Prerequisites.required_marks', 't.name', 'count' => $query->func()->count('q.id')])
                ->where(['Prerequisites.test_id =' => $id])
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
                ->group('Prerequisites.required_marks');

            $query2 = $this->Prerequisites->find();
            $query2
                ->select(['t.name', 'count' => $query2->func()->count('q.id')])
                ->where(['Prerequisites.test_id =' => $id])
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
                ->group('Prerequisites.required_marks');

            $passAll = True;
            foreach($query as $prereq) {
                $pass = False;
                foreach ($query2 as $prereq2) {
                    if($prereq['t']['name'] == $prereq2['t']['name']) {
                        $pass = True;
                        if($prereq2['count']/$prereq['count']*100 < $prereq['required_marks']) {
                            $passAll = False;
                            $this->Flash->error(__('To attempt this test you must attain a mark of '.($prereq['required_marks']).'% in '.$prereq['t']['name']));
                        }
                    }
                }
                if($pass == False) {
                    $passAll = False;
                    $this->Flash->error(__('To attempt this test you must attain a mark of '.($prereq['required_marks']).'% in '.$prereq['t']['name']));
                }
            }

            if ($passAll == False) {
                return $this->redirect(['controller' => 'Courses', 'action' => 'view', $test->course_id]);
            }
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Courses']
        ];
        $tests = $this->paginate($this->Tests);

        $this->set(compact('tests'));
        $this->set('_serialize', ['tests']);
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $test = $this->Tests->get($id, [
            'contain' => ['Courses', 'Prerequisites', 'Questions']
        ]);
        $this->passedPrerequisites($id, $test);

        $this->set('test', $test);
        $this->set('_serialize', ['test']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->loadModel('Prerequisites');
        $test = $this->Tests->newEntity();
        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            $test->course_id = $id;
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }

        $tests = $this->Tests->find('list', ['conditions' => ['Tests.course_id =' => $id],'limit' => 200]);

        $this->set(compact('test', 'tests'));
        $this->set('_serialize', ['test']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $test = $this->Tests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $courses = $this->Tests->Courses->find('list', ['limit' => 200]);
        $this->set(compact('test', 'courses'));
        $this->set('_serialize', ['test']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Tests->get($id);
        if ($this->Tests->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
