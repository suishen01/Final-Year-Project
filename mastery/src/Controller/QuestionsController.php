<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Client;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[] paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
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
        if ((isset($user['role']) && $user['role'] === 'Teacher') || in_array($this->request->getParam('action'), ['view'])) {
            return true;
        }

        return parent::isAuthorized($user);
    }
    public function passedPrerequisites($id)
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
                        }
                    }
                }
                if($pass == False) {
                    $passAll = False;
                }
            }

            if ($passAll == False) {
                throw new UnauthorizedException();
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
        $questions = $this->Questions->find('all', [
            'conditions' => ['Questions.test_id =' => $question->test_id]
        ]);
        $this->passedPrerequisites($question->test_id);
        $completed = [];
        
        if ($this->Auth->user()['role'] == 'Student') {
          $this->loadModel('Marks');
          $query = $this->Marks->find();
          $query
              ->select(['Marks.question_id'])
              ->where(['q.test_id =' => $question->test_id])
              ->hydrate(false)
              ->join([
                  'table' => 'questions',
                  'alias' => 'q',
                  'type' => 'LEFT',
                  'conditions' => [
                      'q.id = Marks.question_id'
                  ]
              ]);
          foreach($query as $q) {
            array_push($completed, $q['question_id']);
          }
        }
        $this->set('completed', $completed);
        $this->set('question', $question);
        $this->set('questions', $questions->toArray());
        $this->set('_serialize', ['question']);


        // Set the language and filename to be used for compilation
        $language = "java";
        $filename = "main.java";
        $output ='';
        $this->set('output', $output);

        if ($this->request->is('post')) {

          $source = $this->request->getData()['answer'];
          $result = $this->remoteExecuteSource($source, $question->field1, $question->field2, $language, $filename);
          $output = $this->FormSuccessfulResults($result);

          if ($result['result'] === 'SUCCESS') {
            if (strcmp($output, $question->answer) === 0) {
	            $result = 'Congrats! You passed this question.';

              $marksTable = TableRegistry::get('Marks');
              $mark = $marksTable->newEntity();
              $mark->question_id = $id;
              $mark->user_id = $this->Auth->user()['id'];
              $marksTable->save($mark);

            } else {
	            $result = 'Wrong answer, please try again.';
            }
          } else {
	          $result = 'The code contains an error.';
          }
          $this->set('output', $output);
      	  echo "<tr><td> <input type=\"hidden\" id=\"result\" value=\"$result\"></td></tr>";
      	  echo "<tr><td> <input type=\"hidden\" id=\"output\" value=\"$output\"></td></tr>";
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->loadModel('Tests');
        $test = $this->Tests->get($id);
        $question = $this->Questions->newEntity();
        if ($this->request->is('post')) {
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question->test_id = $id;
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



    // This function is responsible for communicating with the compilation engine.  The response is packaged up into an
    // associative array with the following keys:
    //	   result - this is either COMPILE_ERROR, RUNTIME_ERROR or SUCCESS
    //	   stdout - this is standard output, which is relevant if result is SUCCESS
    //	   error_message - this is the compiler error message if result if COMPILE_ERROR
    //	   stderr - this is standard error if result is RUNTIME_ERROR
    public function remoteExecuteSource($source, $field1, $field2, $language, $filename) {

    	// This is a hard-coded IP address of the compilation engine service.  Yes, I know.
    	$SERVER_HOST = "localhost";

    	// Set URL
    	$url = "http://".$SERVER_HOST."/jobe/index.php/restapi/runs";
    	// Prepare the run_spec for submission
    	$source = $field1."".$source."".$field2;
    	$run_spec = array("run_spec" => array("sourcecode" => $source, "language_id" => $language, "sourcefilename" => $filename));
    	$run_spec_json = json_encode($run_spec);

      $http = new Client();
      $result = $http->post($url, $run_spec_json, ['type' => 'json']);

    	$evaluatedResult = "";

    	// Successful evaluation with response included
    	if ($result->code == 200) {
    		$evaluatedResult = $this->ProcessReturnResult($result->json);
    	}
    	// The job has not been evaluated, but is in a queue - attempt to get the status, otherwise give up
    	/*else if ($result->code == 202) {
    		$run_id = $result;
    		$result->json = $this->JobeGetRunStatusOfQueuedJob($run_id);
    		if ($run_result == false) {
    			return array("result" => "RUNTIME_ERROR", "error_message" => "", "stdout" => "", "stderr" => "The compilation engine is really busy right now - please try again later!");
    		} else {
    			$evaluatedResult = $this->ProcessReturnResult($result->json);
    		}
    	}*/
    	return $evaluatedResult;
    }

    // We have a run_id for a previous submission to the compilation engine which was queued.  We will attempt to view the status of this
    function JobeGetRunStatusOfQueuedJob($run_id)
    {
    	// Not implemented in current version of compilation engine
    	return false;
    }

    // Code has been evaluated and the result should be interpreted.
    // $result stores an associate array with the fields: run_id, outcome, cmpinfo, stdout, stderr
    function ProcessReturnResult($executionResult)
    {
    	$result = "";
    	$error_message = "";
    	$stdout = "";
    	$stderr = "";

    	if ($executionResult['outcome'] == 15) {
    		$result = "SUCCESS";
    		$stdout = $executionResult['stdout'];
    	} else if ($executionResult['outcome'] == 11) {
    		$result = "COMPILE_ERROR";
    		$error_message = $executionResult['cmpinfo'];
    	} else if ($executionResult['outcome'] == 12) {
    		$result = "RUNTIME_ERROR";
    		$stderr = $executionResult['stderr'];
    	} else if ($executionResult['outcome'] == 13) {
    		$result = "RUNTIME_ERROR";
    		$stderr = "Your submission took too long to execute.";
    	} else if ($executionResult['outcome'] == 17) {
    		$result = "RUNTIME_ERROR";
    		$stderr = $executionResult['stderr'];
    	} else if ($executionResult['outcome'] == 19) {
    		$result = "RUNTIME_ERROR";
    		$stderr = $executionResult['stderr'];
    	} else {
    		$result = "RUNTIME_ERROR";
    		$stderr = "Unfortunately the compilation engine is not working properly at the moment. Please contact an administrator.";
    	}
    	return array("result" => $result, "error_message" => $error_message, "stdout" => $stdout, "stderr" => $stderr);
    }

    public function FormSuccessfulResults($result)
    {
    	if ($result['result']=="SUCCESS") {
    		return $result['stdout'];
    	} else {
    		if ($result['stderr']==""){
    			return $result['error_message'];
    		}
    		return $result['stderr'];
    	}
    }

}
