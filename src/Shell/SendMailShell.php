<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Mailer\Email;
use App\Controller\TasksController;

class SendMailShell extends Shell
{
  public function initialize()
  {
    parent::initialize();
    $this->Tasks = new TasksController();
  }

  public function main(){
    $email = new Email('default');

    $tasks = $this->Tasks->tasksList();
    foreach ($tasks as $task) {
      $info = [];
      if(isset($task['endtime'])){ // タスクの終了日が設定されている場合
        if (date("Y-m-d", strtotime("+ 1 day")) == $task['endtime']->i18nFormat("YYYY-MM-dd")){ // タスク終了の1日前
            $info['subject'] = 'タスク終了1日前のお知らせです。';
            $info['comment'] = "「{$task['description']}」タスクがもうすぐ終了の締切日です。タスクは順調に進んでいますか。もう少しかかりそうな場合は延長しても大丈夫ですよ。";
        } else if (date("Y-m-d") == $task['endtime']->i18nFormat("YYYY-MM-dd")){ // タスク終了当日
            $info['subject'] = 'タスク終了予定日のお知らせです。';
            $info['comment'] = "いよいよ「{$task['description']}」タスクの締切日となりました。タスクは完了していますか。完了していれば、タスクの状態を完了にしてください。完了していなければ期間を延長しても大丈夫です。";
        }
      }
      if (isset($task['starttime'])) { // タスクの開始日が設定されている場合
        if (date("Y-m-d", strtotime("+ 1 day")) == $task['starttime']->i18nFormat("YYYY-MM-dd")) { // タスク開始の1日前
            $info['subject'] = 'タスク開始1日前のお知らせです。';
            $info['comment'] = "いよいよ「{$task['description']}」タスクが開始直前となりました。準備はできていますか。";
        } else if (date("Y-m-d") == $task['starttime']->i18nFormat("YYYY-MM-dd")) { // タスク開始当日
            $info['subject'] = 'タスク開始予定日のお知らせです。';
            $info['comment'] = "「{$task['description']}」タスクが開始となりました。本日しなければならないことは把握できていますか。";
        }
      }

      $info['email'] = $task['user']['email'];

      if (isset($info['subject']) && isset($info['email'])){
        $info['description'] = $task['description'];
        $info['comment'] .= "わからないことがあれば、友達や先生と相談しながら無理なく進めていきましょう！";

        $email->to($info['email'])
          ->template('task', 'college')
          ->emailFormat('html')
          ->from(['xu.lab.fitc6@gmail.com' => 'ゼミ管理システム'])
          ->subject($info['subject'])
          ->viewVars(['value' => $info])
          ->send();
      }

      // サブタスクのメール送信
      foreach ($task['subtasks'] as $subtask) {
        $info2 = [];
        if(isset($subtask['endtime'])){ // サブタスクの終了日が設定されている場合
          if (date("Y-m-d", strtotime("+ 1 day")) == $subtask['endtime']->i18nFormat("YYYY-MM-dd")){ // サブタスク終了の1日前
              $info2['subject'] = 'サブタスク終了1日前のお知らせです。';
              $info2['comment'] = "「{$subtask['subdescription']}」サブタスクがもうすぐ終了の締切日です。サブタスクは順調に進んでいますか。もう少しかかりそうな場合は延長しても大丈夫ですよ。";
          } else if (date("Y-m-d") == $subtask['endtime']->i18nFormat("YYYY-MM-dd")){ // サブタスク終了当日
              $info2['subject'] = 'サブタスク終了予定日のお知らせです。';
              $info2['comment'] = "いよいよ「{$subtask['subdescription']}」サブタスクの締切日となりました。サブタスクは完了していますか。完了していれば、サブタスクの状態を完了にしてください。完了していなければ期間を延長しても大丈夫です。";
          }
        }
        if (isset($subtask['starttime'])) { // サブタスクの開始日が設定されている場合
          if (date("Y-m-d", strtotime("+ 1 day")) == $subtask['starttime']->i18nFormat("YYYY-MM-dd")) { // サブタスク開始の1日前
              $info2['subject'] = 'サブタスク開始1日前のお知らせです。';
              $info2['comment'] = "いよいよ「{$subtask['subdescription']}」サブタスクが開始直前となりました。準備はできていますか。";
          } else if (date("Y-m-d") == $subtask['starttime']->i18nFormat("YYYY-MM-dd")) { // サブタスク開始当日
              $info2['subject'] = 'サブタスク開始予定日のお知らせです。';
              $info2['comment'] = "「{$subtask['subdescription']}」サブタスクが開始となりました。本日しなければならないことは把握できていますか。";
          }
        }

        $info2['email'] = $task['user']['email'];
        if (isset($info2['subject']) && isset($info2['email'])){
          $info2['subdescription'] = $subtask['subdescription'];
          $info2['comment'] .= "わからないことがあれば、友達や先生と相談しながら無理なく進めていきましょう！";
          $this->out($info2);

          $email->to($info2['email'])
            ->template('subtask', 'college')
            ->emailFormat('html')
            ->from(['xu.lab.fitc6@gmail.com' => 'ゼミ管理システム'])
            ->subject($info2['subject'])
            ->viewVars(['value' => $info2])
            ->send();
        }
      }
    }
  }
}
