<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Marks Controller
 *
 * @property \App\Model\Table\MarksTable $Marks
 *
 * @method \App\Model\Entity\Mark[] paginate($object = null, array $settings = [])
 */
class MarksController extends AppController
{
    /*public function afterFilter(Event $event)
    {
        parent::afterFilter($event);
        if (!$this->isAuthorized($this->Auth->user())) {
            throw new UnauthorizedException();
        }
    }*/
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Questions']
        ];
        $marks = $this->paginate($this->Marks);

        $this->set(compact('marks'));
        $this->set('_serialize', ['marks']);
    }

    /**
     * View method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $mark = $this->Marks->get($id, [
            'contain' => ['Users', 'Questions']
        ]);

        $this->set('mark', $mark);
        $this->set('_serialize', ['mark']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $mark = $this->Marks->newEntity();
        if ($this->request->is('post')) {
            $mark = $this->Marks->patchEntity($mark, $this->request->getData());
            if ($this->Marks->save($mark)) {
                $this->Flash->success(__('The mark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mark could not be saved. Please, try again.'));
        }
        $users = $this->Marks->Users->find('list', ['limit' => 200]);
        $questions = $this->Marks->Questions->find('list', ['limit' => 200]);
        $this->set(compact('mark', 'users', 'questions'));
        $this->set('_serialize', ['mark']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $mark = $this->Marks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $mark = $this->Marks->patchEntity($mark, $this->request->getData());
            if ($this->Marks->save($mark)) {
                $this->Flash->success(__('The mark has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The mark could not be saved. Please, try again.'));
        }
        $users = $this->Marks->Users->find('list', ['limit' => 200]);
        $questions = $this->Marks->Questions->find('list', ['limit' => 200]);
        $this->set(compact('mark', 'users', 'questions'));
        $this->set('_serialize', ['mark']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Mark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $mark = $this->Marks->get($id);
        if ($this->Marks->delete($mark)) {
            $this->Flash->success(__('The mark has been deleted.'));
        } else {
            $this->Flash->error(__('The mark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
