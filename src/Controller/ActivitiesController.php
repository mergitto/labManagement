<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Activities Controller
 *
 * @property \App\Model\Table\ActivitiesTable $Activities
 */
class ActivitiesController extends AppController
{


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tasksModel = $this->loadModel('Tasks');
        $user = $this->Auth->user();
        $activity = $this->Activities->find()->where(['user_id' => $user['id']])->contain(['Users']);
        if($activity->isEmpty()){ // 研究テーマを登録していない場合は登録画面へ遷移
          return $this->redirect(['action' => 'add', $user['id']]);
        } else {
          $result = $activity->first();
        }
        $plans = $this->Activities->Plans->find()->where(['activity_id' => $result['id']])->order(['Plans.created' => 'ASC']);
        $tasks = $tasksModel->find()->where(['user_id' => $user['id']])->contain(['Subtasks'])->order(['Tasks.created' => 'ASC']);
        $allTasks = $tasksModel->find()->contain(['Subtasks'])->order(['Tasks.created' => 'ASC']);
        $todayTasks = $tasksModel->find()
          ->where(['user_id' => $user['id']])
          ->where(['starttime <=' => date('Y-m-d H:i:s')])
          ->where(['status =' => PROCESS]) // status=処理中(PROCESS)という条件を付加
          ->contain(['Subtasks'])
          ->order(['Tasks.created' => 'ASC']);
        $subList = $this->subTasksList($tasks);
        $taskRate = $this->taskProgressRate($allTasks);
        $activities = $this->Activities->find()->contain(['Users'])->order(['Activities.created' => 'ASC']);
        $this->set(compact('result', 'plans', 'tasks', 'subList', 'todayTasks', 'taskRate', 'activities'));
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $activity = $this->Activities->newEntity();
        if ($this->request->is('post')) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('テーマを追加しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('テーマを追加できませんでした。もう一度試してください。'));
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'users'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $activity = $this->Activities->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $activity = $this->Activities->patchEntity($activity, $this->request->data);
            if ($this->Activities->save($activity)) {
                $this->Flash->success(__('テーマの修正を行いました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('テーマを修正できませんでした。もう一度試してください。'));
        }
        $users = $this->Activities->Users->find('list', ['limit' => 200]);
        $this->set(compact('activity', 'users'));
        $this->set('_serialize', ['activity']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Activity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $activity = $this->Activities->get($id);
        if ($this->Activities->delete($activity)) {
            $this->Flash->success(__('テーマを削除しました。'));
        } else {
            $this->Flash->error(__('テーマを削除できませんでした。もう一度試してください。'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * subTasksList method
     * @param array $tasks
     * @return array subtasks list
     */
    public function subTasksList($tasks)
    {
      $subtasksList = [];
      foreach ($tasks as $key => $task) {
        $subtasksList[$key] = [];
        foreach ($task['subtasks'] as $subtask) {
          $subtasksList[$key][] = $subtask['status'];
        }
      }
      return $subtasksList;
    }

    /**
     * taskProgressRate method
     * @param array $tasks
     * @return array task progress rate
     */
    public function taskProgressRate($allTasks)
    {
      $weightArr = [];
      $status = ['PROCESS', 'CLOSE'];
      $secondDecimal = 2;

      foreach($allTasks as $key => $task) {
        $weightArr[$task['user_id']]['taskWeight'][$task['description']]['weight'] = $task['weight'];
        $weightArr[$task['user_id']]['taskWeight'][$task['description']]['status'] = $status[$task['status']];
        if(isset($weightArr[$task['user_id']]['taskSum'])){
          $weightArr[$task['user_id']]['taskSum'] += $task['weight'];
        } else {
          $weightArr[$task['user_id']]['taskSum'] = $task['weight'];
        }

        $subtaskSum = 0;
        foreach($task['subtasks'] as $subKey => $subtask) {
          $weightArr[$task['user_id']]['subtaskWeight'][$task['description']][$subtask['subdescription']]['weight'] = $subtask['weight'];
          $weightArr[$task['user_id']]['subtaskWeight'][$task['description']][$subtask['subdescription']]['status'] = $status[$subtask['status']];
          $weightArr[$task['user_id']]['subtaskWeight'][$task['description']]['closeRate'] = 0; // 後々statusがCLOSEの割合を追加する
          if(isset($weightArr[$task['user_id']]['subtaskSum'])){
            $weightArr[$task['user_id']]['subtaskSum'] += $subtask['weight'];
          } else {
            $weightArr[$task['user_id']]['subtaskSum'] = $subtask['weight'];
          }
          $subtaskSum += $subtask['weight'];
        }
        // 各タスクのサブタスクの重みの合計を追加
        $weightArr[$task['user_id']]['subtaskWeight'][$task['description']]['subtaskSum'] = $subtaskSum;
      }

      // タスク・サブタスクの割合を計算する
      foreach ($weightArr as $user_id =>  $weight) {
        // 各タスクの重みの計算を行い、$weightArrに追加
        foreach ($weight['taskWeight'] as $description => $taskWeight) {
          $weightArr[$user_id]['taskWeight'][$description]['rate'] = round( (double)$taskWeight['weight'] / (double)$weight['taskSum'] * 100 , 2);
        }

        // 各サブタスクの重みの計算を行い、$weightArrに追加
        foreach ($weight['subtaskWeight'] as $description => $task) {
          if ($task['subtaskSum'] == 0) { // サブタスクを抱えないタスクについて、parentRateをキーにタスクの状態配列を追加
            $weightArr[$user_id]['subtaskWeight'][$description]['parentRate'] = $weightArr[$user_id]['taskWeight'][$description];
          }
          foreach ($task as $subdescription => $subtask) {
            if (isset($subtask['weight'])) {
              $weightArr[$user_id]['subtaskWeight'][$description][$subdescription]['rate']
                = floor( (double)$subtask['weight'] / (double)$task['subtaskSum'] * $weightArr[$user_id]['taskWeight'][$description]['rate']* pow( 10 , $secondDecimal ) ) / pow( 10 , $secondDecimal );
            }
            if ($weightArr[$user_id]['subtaskWeight'][$description][$subdescription]['status'] == "CLOSE") {
              $weightArr[$user_id]['subtaskWeight'][$description]['closeRate'] += $weightArr[$user_id]['subtaskWeight'][$description][$subdescription]['rate'];
            }
            if ($weightArr[$user_id]['subtaskWeight'][$description]['subtaskSum'] == 0 && $weightArr[$user_id]['subtaskWeight'][$description]['parentRate']['status'] == "CLOSE") {
              $weightArr[$user_id]['subtaskWeight'][$description]['closeRate'] = $weightArr[$user_id]['subtaskWeight'][$description]['parentRate']['rate'];
            }
          }
        }
      }
      return $weightArr;
    }

    public function isAuthorized($user)
    {
        $action = $this->request->params['action'];
        // indexページは誰でも見れる
        if (in_array($action, ['index', 'logout'])) {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        // リクエストされたページのActivitiesのuser_idと
        // ログイン中のUseridが一致する場合はその他のアクションも許可する
        $id = $this->request->params['pass'][0];
        $activityUserId = $this->Activities->get($id);
        if ($activityUserId['user_id'] == $user['id']) {
            return true;
        }else{
            $this->Flash->error(__('他のユーザーのテーマは操作できません'));
            return false;
        }
        $this->Flash->error(__('管理者の機能です'));
        return false;
    }
}
