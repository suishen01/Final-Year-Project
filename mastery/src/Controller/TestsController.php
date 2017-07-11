<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests
 *
 * @method \App\Model\Entity\Test[] paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
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
        if ((isset($user['role']) && $user['role'] === 'Teacher') || in_array($this->request->getParam('action'), ['view'])) {
            return true;
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
            'contain' => ['Courses', 'Marks', 'Prerequisites']
        ]);

        $this->loadModel('Prerequisites');
        $query = $this->Prerequisites->find()
            ->select(['t.name', 'Prerequisites.required_marks'])
            ->where(['m.marks < Prerequisites.required_marks'])
            ->orWhere(function ($exp, $q) {
                return $exp->isNull('m.marks');
            })
            ->where(['Prerequisites.test_id =' => $id])
            ->hydrate(false)
            ->join([
                'table' => 'marks',
                'alias' => 'm',
                'type' => 'LEFT',
                'conditions' => [
                    'm.test_id = Prerequisites.pre_id',
                    'm.user_id =' => 1
                ]
            ])
            ->join([
                'table' => 'tests',
                'alias' => 't',
                'type' => 'LEFT',
                'conditions' => [
                    't.id = Prerequisites.pre_id'
                ]
            ])
            ->toArray();

        foreach ($query as $prereq) {
            $this->Flash->error(__('To attempt this test you must attain a mark of '.($prereq['required_marks']).'% in '.$prereq['t']['name']));
        }

        if (sizeof($query) == 0) {
            $this->set('test', $test);
            $this->set('_serialize', ['test']);
        } else {            
            return $this->redirect(['controller' => 'Courses', 'action' => 'view', $test->course_id]);
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Prerequisites');
        $test = $this->Tests->newEntity();
        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));
                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }

        $tests = $this->Tests->find('list', ['limit' => 200]);
        $courses = $this->Tests->Courses->find('list', ['limit' => 200]);
        $this->set(compact('test', 'courses', 'tests'));
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
