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
    public function add($activityUserId = null)
    {
        $task = $this->Tasks->newEntity();
        $user = $this->Auth->user();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('タスクを追加しました。'));

                if ($user['role'] === 'admin') {
                  return $this->redirect(['controller' => 'Admins', 'action' => 'activities', $activityUserId]);
                } else {
                  return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('タスクを追加できませんでした。もう一度試してください。'));
        }
        $users = $this->Tasks->Users->find('list')->where(['id' => $user['id']]);
        $subtasks = $this->Tasks->Subtasks->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users', 'subtasks', 'activityUserId'));
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
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->data);
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('タスクを修正しました。'));

                if ($user['role'] === 'admin') {
                  return $this->redirect(['controller' => 'Admins', 'action' => 'activities', $task['user_id']]);
                } else {
                  return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
                }
            }
            $this->Flash->error(__('タスクを修正できませんでした。もう一度試してください。'));
        }
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
            $this->Flash->success(__('タスクを削除しました。'));
        } else {
            $this->Flash->error(__('タスクを削除できませんでした。もう一度試してください。'));
        }

        return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        if (isset($user['role']) && $user['role'] === 'admin') {
          return true;
        }
        if (in_array($action, ['logout'])) {
          return true;
        }
        // ログインユーザーが扱っているタスクなら編集可能
        if ($this->request->params['pass'][0] == $user['id']) {
          return true;
        }
        $task = $this->Tasks->get($this->request->params['pass'][0]);
        if ($task->user_id == $user['id']) {
          return true;
        } else {
          $this->Flash->error(__('他の人のタスクです'));
          return false;
        }
        return false;
    }
}
