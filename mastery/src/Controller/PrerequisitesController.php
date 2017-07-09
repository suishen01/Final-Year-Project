<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Prerequisites Controller
 *
 * @property \App\Model\Table\PrerequisitesTable $Prerequisites
 *
 * @method \App\Model\Entity\Prerequisite[] paginate($object = null, array $settings = [])
 */
class PrerequisitesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tests']
        ];
        $prerequisites = $this->paginate($this->Prerequisites);

        $this->set(compact('prerequisites'));
        $this->set('_serialize', ['prerequisites']);
    }

    /**
     * View method
     *
     * @param string|null $id Prerequisite id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $prerequisite = $this->Prerequisites->get($id, [
            'contain' => ['Tests']
        ]);

        $this->set('prerequisite', $prerequisite);
        $this->set('_serialize', ['prerequisite']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $prerequisite = $this->Prerequisites->newEntity();
        if ($this->request->is('post')) {
            $prerequisite = $this->Prerequisites->patchEntity($prerequisite, $this->request->getData());
            if ($this->Prerequisites->save($prerequisite)) {
                $this->Flash->success(__('The prerequisite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The prerequisite could not be saved. Please, try again.'));
        }
        $tests = $this->Prerequisites->Tests->find('list', ['limit' => 200]);
        $this->set(compact('prerequisite', 'tests'));
        $this->set('_serialize', ['prerequisite']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Prerequisite id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $prerequisite = $this->Prerequisites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $prerequisite = $this->Prerequisites->patchEntity($prerequisite, $this->request->getData());
            if ($this->Prerequisites->save($prerequisite)) {
                $this->Flash->success(__('The prerequisite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The prerequisite could not be saved. Please, try again.'));
        }
        $tests = $this->Prerequisites->Tests->find('list', ['limit' => 200]);
        $this->set(compact('prerequisite', 'tests'));
        $this->set('_serialize', ['prerequisite']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Prerequisite id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $prerequisite = $this->Prerequisites->get($id);
        if ($this->Prerequisites->delete($prerequisite)) {
            $this->Flash->success(__('The prerequisite has been deleted.'));
        } else {
            $this->Flash->error(__('The prerequisite could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
