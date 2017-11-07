<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * AdminActivities component
 */
class AdminActivitiesComponent extends Component
{
    /**
     * @param string $body 処理対象のテキスト
     * @param string|null $link_title リンクテキスト
     * @return string
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
}
