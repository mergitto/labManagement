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
                $this->Flash->success(__('サブタスクを追加しました。'));

                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('サブタスクを追加できませんでした。もう一度試してください。'));
        }
        $user = $this->Auth->user();
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', [
          'keyField' => 'id',
          'valueField' => 'description'
        ])->where(['user_id' => $user['id']]);
        if($tasks->count() == 0) {
          $this->Flash->success(__('まずはタスクを登録してください'));
          return $this->redirect(['controller' => 'Tasks', 'action' => 'add']);
        }
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
                $this->Flash->success(__('サブタスクを修正しました。'));

                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
            }
            $this->Flash->error(__('サブタスクを修正できませんでした。もう一度試してください。'));
        }
        $user = $this->Auth->user();
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', [
          'keyField' => 'id',
          'valueField' => 'description'
        ])->where(['user_id' => $user['id']]);
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
            $this->Flash->success(__('サブタスクを削除しました。'));
        } else {
            $this->Flash->error(__('サブタスクを削除できませんでした。もう一度試してください。'));
        }

        return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // add, editページは誰でも見れる
        if (in_array($action, ['add','edit','logout'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }
}
