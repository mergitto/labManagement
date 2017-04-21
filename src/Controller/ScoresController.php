<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Scores Controller
 *
 * @property \App\Model\Table\ScoresTable $Scores
 */
class ScoresController extends AppController
{
   /**
    * Score ajax method
    *
    * @return \Cake\Network\Response|null
    */
    public function scoreAjax()
    {
      $result = [];
      $this->autoRender = FALSE;
      if($this->request->is('ajax')) {
        if($this->request->data['scoreFlag'] == 'false') {
          $score = $this->Scores->newEntity();
          $score = $this->Scores->patchEntity($score, $this->request->data);
        }else{
          $score = $this->Scores->get($this->request->data['score_id']);
          $score = $this->Scores->patchEntity($score, $this->request->data);
        }
        if($this->Scores->save($score)){
          $result['scoreFlag'] = $score['scoreFlag'];
          $result['score_id'] = $score->id;
          echo json_encode($result);
        }
      }
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Attachments']
        ];
        $scores = $this->paginate($this->Scores);

        $this->set(compact('scores'));
        $this->set('_serialize', ['scores']);
    }

    /**
     * View method
     *
     * @param string|null $id Score id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $score = $this->Scores->get($id, [
            'contain' => ['Users', 'Attachments']
        ]);

        $this->set('score', $score);
        $this->set('_serialize', ['score']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $score = $this->Scores->newEntity();
        if ($this->request->is('post')) {
            $score = $this->Scores->patchEntity($score, $this->request->data);
            if ($this->Scores->save($score)) {
                $this->Flash->success(__('The score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The score could not be saved. Please, try again.'));
        }
        $users = $this->Scores->Users->find('list', ['limit' => 200]);
        $attachments = $this->Scores->Attachments->find('list', ['limit' => 200]);
        $this->set(compact('score', 'users', 'attachments'));
        $this->set('_serialize', ['score']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Score id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $score = $this->Scores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $score = $this->Scores->patchEntity($score, $this->request->data);
            if ($this->Scores->save($score)) {
                $this->Flash->success(__('The score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The score could not be saved. Please, try again.'));
        }
        $users = $this->Scores->Users->find('list', ['limit' => 200]);
        $attachments = $this->Scores->Attachments->find('list', ['limit' => 200]);
        $this->set(compact('score', 'users', 'attachments'));
        $this->set('_serialize', ['score']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Score id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $score = $this->Scores->get($id);
        if ($this->Scores->delete($score)) {
            $this->Flash->success(__('The score has been deleted.'));
        } else {
            $this->Flash->error(__('The score could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // index, view, logoutページは誰でも見れる
        if (in_array($action, ['index','view','logout','scoreAjax'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        return false;
    }
}
