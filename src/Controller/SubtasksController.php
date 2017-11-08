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
    public function add($activityUserId = null)
    {
        $subtask = $this->Subtasks->newEntity();
        $user = $this->Auth->user();
        if ($this->request->is('post')) {
          $subtask = $this->Subtasks->patchEntity($subtask, $this->request->data);
          $timeFlag = $this->taskTimeValid($this->request->data['tasks']['_ids'], $this->request->data['starttime'], $this->request->data['endtime']);
          if (!$timeFlag['startFlag']) {
            $this->Flash->error(__('「'.$timeFlag['description'].'」タスクの開始期間よりも早いです。開始期間を'.$timeFlag['starttime'].'よりも後の期間に修正してください。'));
          } else if (!$timeFlag['endFlag']) {
            $this->Flash->error(__('「'.$timeFlag['description'].'」タスクの締切期間よりも遅くなっています。締切期間を'.$timeFlag['endtime'].'よりも前の期間に修正してください。'));
          } else {
            if ($this->Subtasks->save($subtask)) {
              $this->Flash->success(__('サブタスクを追加しました。'));
              if ($user['role'] === 'admin') {
                return $this->redirect(['controller' => 'Admins', 'action' => 'activities', $activityUserId]);
              } else {
                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
              }
            }
            $this->Flash->error(__('サブタスクを追加できませんでした。もう一度試してください。'));
          }
        }
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', [
          'keyField' => 'id',
          'valueField' => 'description'
        ])->where(['user_id' => $activityUserId]);
        if($tasks->count() == 0) {
          $this->Flash->success(__('まずはタスクを登録してください'));
          return $this->redirect(['controller' => 'Tasks', 'action' => 'add']);
        }
        $this->set(compact('subtask', 'users', 'tasks', 'activityUserId'));
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
        $user = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
          $this->request->data['starttime'] = date('Y-m-d', strtotime($this->request->data['starttime']));
          $this->request->data['endtime'] = date('Y-m-d', strtotime($this->request->data['endtime']));
          $subtask = $this->Subtasks->patchEntity($subtask, $this->request->data);
          $timeFlag = $this->taskTimeValid($this->request->data['tasks']['_ids'], $this->request->data['starttime'], $this->request->data['endtime']);
          if (!$timeFlag['startFlag']) {
            $this->Flash->error(__('「'.$timeFlag['description'].'」タスクの開始期間よりも早いです。開始期間を'.$timeFlag['starttime'].'よりも後の期間に修正してください。'));
          } else if (!$timeFlag['endFlag']) {
            $this->Flash->error(__('「'.$timeFlag['description'].'」タスクの締切期間よりも遅くなっています。締切期間を'.$timeFlag['endtime'].'よりも前の期間に修正してください。'));
          } else {
            if ($this->Subtasks->save($subtask)) {
              $this->Flash->success(__('サブタスクを修正しました。'));

              if ($user['role'] === 'admin') {
                return $this->redirect(['controller' => 'Admins', 'action' => 'activities', $subtask['user_id']]);
              } else {
                return $this->redirect(['controller' => 'Activities', 'action' => 'index']);
              }
            }
          $this->Flash->error(__('サブタスクを修正できませんでした。もう一度試してください。'));
          }
        }
        $users = $this->Subtasks->Users->find('list', ['limit' => 200]);
        $tasks = $this->Subtasks->Tasks->find('list', [
          'keyField' => 'id',
          'valueField' => 'description'
        ])->where(['user_id' => $subtask['user_id']]);
        $this->set(compact('subtask', 'users', 'tasks'));
        $this->set('_serialize', ['subtask']);
    }

    /**
     * task validation list method
     * @param array $taskId $starttime $endtime
     * @return arrya tasks list
     */
    public function taskTimeValid($tasksId, $starttime, $endtime)
    {
      foreach ($tasksId as $taskId) {
        $task = $this->Subtasks->Tasks->get($taskId);
        if (isset($task['starttime']) && isset($task['endtime'])) {
          $starttime = date('Y-m-d', strtotime($starttime));
          $endtime = date('Y-m-d', strtotime($endtime));
          if ($task['starttime']->i18nFormat("YYYY-MM-dd") > $starttime) {
            $startValidFrag = ['starttime' => $task['starttime']->i18nFormat("YYYY-MM-dd"), 'description' => $task['description'], 'startFlag' => false, 'endFlag' => true];
            return $startValidFrag;
          }
          if ($task['endtime']->i18nFormat("YYYY-MM-dd") < $endtime) {
            $endValidFrag = ['endtime' => $task['endtime']->i18nFormat("YYYY-MM-dd"), 'description' => $task['description'], 'startFlag' => true, 'endFlag' => false];
            return $endValidFrag;
          }
        }
      }
      return ['startFlag' => true, 'endFlag' => true];
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
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        $action = $this->request->params['action'];
        if (in_array($action, ['logout'])) {
            return true;
        }
        // ログインユーザーが扱っているサブタスクなら編集可能
        if ($this->request->params['pass'][0] == $user['id']) {
          return true;
        }
        $subtask = $this->Subtasks->get($this->request->params['pass'][0]);
        if ($subtask->user_id == $user['id']) {
          return true;
        } else {
          $this->Flash->error(__('他の人のタスクです'));
          return false;
        }
        return false;
    }
}
