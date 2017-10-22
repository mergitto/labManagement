<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }
        $user = $this->Auth->user();
        $users = $this->Tasks->Users->find('list')->where(['id' => $user['id']]);
        $subtasks = $this->Tasks->Subtasks->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'subtasks'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Subtasks']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }
        $user = $this->Auth->user();
        $users = $this->Tasks->Users->find('list', ['limit' => 200]);
        $subtasks = $this->Tasks->Subtasks->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'subtasks'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // indexページは誰でも見れる
        if (in_array($action, ['add','edit','logout'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのUser idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $current_user = $this->Tasks->get($id);
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
