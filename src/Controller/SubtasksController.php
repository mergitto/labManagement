<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Subtasks Controller
 *
 * @property \App\Model\Table\SubtasksTable $Subtasks
 */
class SubtasksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $subtasks = $this->paginate($this->Subtasks);

        $this->set(compact('subtasks'));
        $this->set('_serialize', ['subtasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Subtask id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subtask = $this->Subtasks->get($id, [
            'contain' => ['Users', 'Tasks']
        ]);

        $this->set('subtask', $subtask);
        $this->set('_serialize', ['subtask']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subtask = $this->Subtasks->newEntity();
        if ($this->request->is('post')) {
            $subtask = $this->Subtasks->patchEntity($subtask, $this->request->data);
            if ($this->Subtasks->save($subtask)) {
                $this->Flash->success(__('The subtask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subtask could not be saved. Please, try again.'));
        }
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('subtask', 'users', 'tasks'));
        $this->set('_serialize', ['subtask']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Subtask id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subtask = $this->Subtasks->get($id, [
            'contain' => ['Tasks']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subtask = $this->Subtasks->patchEntity($subtask, $this->request->data);
            if ($this->Subtasks->save($subtask)) {
                $this->Flash->success(__('The subtask has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subtask could not be saved. Please, try again.'));
        }
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', ['limit' => 200]);
        $this->set(compact('subtask', 'users', 'tasks'));
        $this->set('_serialize', ['subtask']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Subtask id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subtask = $this->Subtasks->get($id);
        if ($this->Subtasks->delete($subtask)) {
            $this->Flash->success(__('The subtask has been deleted.'));
        } else {
            $this->Flash->error(__('The subtask could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // indexページは誰でも見れる
        if (in_array($action, ['index'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Subtasks->get($id);
        if ($current_user->user_id == $user['id']) {
            return true;
        }else{
            $this->Flash->error(__('他のユーザーのファイルは操作できません'));
            return false;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }
}
