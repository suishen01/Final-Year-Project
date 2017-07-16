<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[] paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
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
            'contain' => ['Tests']
        ];
        $questions = $this->paginate($this->Questions);

        $this->set(compact('questions'));
        $this->set('_serialize', ['questions']);
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['Tests']
        ]);

        $this->set('question', $question);
        $this->set('_serialize', ['question']);

        if ($this->request->is('post')) {
            $answer = $this->Questions->get($id);
            if ($answer['answer'] == $this->request->getData()['answer']) {
                $this->Flash->success(__('Correct.'));
                $marksTable = TableRegistry::get('Marks');
                $mark = $marksTable->newEntity();

                $mark->correct = 1;
                $mark->user_id = $this->Auth->user()['id'];
                $mark->question_id = $id;

                $marksTable->save($mark);
                return $this->redirect(['controller' => 'Tests','action' => 'view', $question['test_id']]);

            } else {
                $this->Flash->error(__('Incorrect. Please, try again.'));
            }
           
        }

        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $question = $this->Questions->newEntity();
        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question could not be saved. Please, try again.'));
        }
        $tests = $this->Questions->Tests->find('list', ['limit' => 200]);
        $this->set(compact('question', 'tests'));
        $this->set('_serialize', ['question']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question could not be saved. Please, try again.'));
        }
        $tests = $this->Questions->Tests->find('list', ['limit' => 200]);
        $this->set(compact('question', 'tests'));
        $this->set('_serialize', ['question']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        if ($this->Questions->delete($question)) {
            $this->Flash->success(__('The question has been deleted.'));
        } else {
            $this->Flash->error(__('The question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     public function check($answer)
    {
        $question = $this->Questions->get($id);
        if ($question['answer'] == $answer) {
            $this->Flash->success(__('Correct.'));
        } else {
            $this->Flash->error(__('Incorrect. Please, try again.'));
        }
    }
}

