<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * TaskFlagClear shell command.
 */
class TaskFlagClearShell extends Shell
{
  public function initialize()
  {
    parent::initialize();
    $this->loadModel('Users');
  }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
      $users = $this->Users->find();
      foreach($users as $user) {
        // モーダルのためのフラグを0に戻す
        $user['task_modal_flg'] = 0;
        $this->Users->save($user);
      }
    }
}
