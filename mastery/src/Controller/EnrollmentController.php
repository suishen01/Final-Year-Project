<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Enrollment Controller
 *
 * @property \App\Model\Table\EnrollmentTable $Enrollment
 *
 * @method \App\Model\Entity\Enrollment[] paginate($object = null, array $settings = [])
 */
class EnrollmentController extends AppController
{
    public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
        if (!$this->isAuthorized($this->Auth->user())) {
            throw new UnauthorizedException();
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
            'contain' => ['Users', 'Courses']
        ];
        $enrollment = $this->paginate($this->Enrollment);

        $this->set(compact('enrollment'));
        $this->set('_serialize', ['enrollment']);
    }

    /**
     * View method
     *
     * @param string|null $id Enrollment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enrollment = $this->Enrollment->get($id, [
            'contain' => ['Users', 'Courses']
        ]);

        $this->set('enrollment', $enrollment);
        $this->set('_serialize', ['enrollment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enrollment = $this->Enrollment->newEntity();
        if ($this->request->is('post')) {
            $enrollment = $this->Enrollment->patchEntity($enrollment, $this->request->getData());
            if ($this->Enrollment->save($enrollment)) {
                $this->Flash->success(__('The enrollment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enrollment could not be saved. Please, try again.'));
        }
        $users = $this->Enrollment->Users->find('list', ['limit' => 200]);
        $courses = $this->Enrollment->Courses->find('list', ['limit' => 200]);
        $this->set(compact('enrollment', 'users', 'courses'));
        $this->set('_serialize', ['enrollment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Enrollment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $enrollment = $this->Enrollment->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $enrollment = $this->Enrollment->patchEntity($enrollment, $this->request->getData());
            if ($this->Enrollment->save($enrollment)) {
                $this->Flash->success(__('The enrollment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The enrollment could not be saved. Please, try again.'));
        }
        $users = $this->Enrollment->Users->find('list', ['limit' => 200]);
        $courses = $this->Enrollment->Courses->find('list', ['limit' => 200]);
        $this->set(compact('enrollment', 'users', 'courses'));
        $this->set('_serialize', ['enrollment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Enrollment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enrollment = $this->Enrollment->get($id);
        if ($this->Enrollment->delete($enrollment)) {
            $this->Flash->success(__('The enrollment has been deleted.'));
        } else {
            $this->Flash->error(__('The enrollment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
