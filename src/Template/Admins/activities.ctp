<?php if (!isset($result)): ?>
<form class="form-horizontal" action="/hoge/foo" method="post">
  <div class="form-group">
    <?= $this->Form->input('users', ['type' => 'select', 'options' => $users, 'label' => '閲覧するユーザーを選択してください','class' => 'form-control', 'id' => 'userAc']) ?>
  </div>
</form>
<?php if ($this->request->params['pass'][0] != 0): ?>
  <h1><?= __('そのユーザーは行動計画をまだ始めていません。'); ?></h1>
<?php endif ?>
<?php else: ?>
<form class="form-horizontal" action="/hoge/foo" method="post">
  <div class="form-group">
    <?= $this->Form->input('users', ['type' => 'select', 'options' => $users, 'label' => '閲覧するユーザーを選択してください','class' => 'form-control', 'id' => 'userAc']) ?>
  </div>
</form>
<div class="activities content container">
  <div class="row text-center">
    <div class="col-xs-12">
      <h1 class="theme">
        <div class="themeHead">
          <span class="font-20"><?= $result['user']['nickname'].__('さんの研究テーマ') ?></span>
        </div>
        <?= $result['theme']; ?>
        <div class="row">
          <div class="col-xs-2">
            <span class="font-16 "><?= __('進捗度'); ?></span>
          </div>
          <div class="col-xs-8">
            <div class="progress">
              <?php
                $progressColor = ['success', 'info', 'warning', 'danger', 'striped'];
                $count = 0;
                if (!isset($taskRate[$result['user']['id']])) {
                  print __('<p class="font-16 color-bk">まだ研究活動が始まっていません。</p>');
                } else {
                  foreach($taskRate[$result['user']['id']]['subtaskWeight'] as $taskName => $taskTitle) {
                    if (isset($taskTitle['closeRate'])) {
                      print "<div class='progress-bar progress-bar-".$progressColor[$count % count($progressColor)]." progress-bar-striped active' role='progressbar' style='width:".$taskTitle["closeRate"]."%;'>";
                      print __($taskName);
                      print "</div>";
                      $count++;
                    }
                  }
                }
              ?>
            </div>
          </div>
          <div class="col-xs-2"></div>
        </div>
      </h1>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <h2><?= __('本日のタスク') ?></h2>
      <hr class="today-plan-hr">
      <?php $todayTasks->isEmpty() ? print __('<div class="text-center font-20 color-1">本日のタスクはないです。タスクを設定してください。</div>') : ''; ?>
      <ul>
        <div class="text-left">
          <?php foreach($todayTasks as $todayTask): ?>
            <li>
              <?php date('Y-m-d') <= $todayTask['endtime']->i18nFormat('YYYY-MM-dd') ? print '<div>': print '<div class="limitOver">'; ?>
                <span class="font-20"><?= $todayTask['description'] ?></span>
                <span class="font-14"><?= $todayTask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($todayTask['starttime']))].__('〜').$todayTask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($todayTask['endtime']))] ?></span>
                <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$todayTask['id']]); ?>
              </div>
            </li>
            <ul>
              <?php foreach($todayTask['subtasks'] as $todaySubtask): ?>
                <?php $startSubtask = $todaySubtask['starttime']->i18nFormat('YYYY-MM-dd'); ?>
                <?php $endSubtask = $todaySubtask['endtime']->i18nFormat('YYYY-MM-dd'); ?>
                <?php $startWeek = $week[date('w', strtotime($todaySubtask['starttime']))] ?>
                <?php $endWeek = $week[date('w', strtotime($todaySubtask['endtime']))] ?>
                <li>
                <span class="font-14 color-<?= $todaySubtask['status']?>"><?= $todaySubtask['subdescription'] ?></span>
                <?php for($i=0; $todaySubtask['weight'] > $i; $i++){ echo "★"; } ?>
                <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$todaySubtask['id']], ['class' => "status{$todaySubtask['status']}"]); ?></p>
                <?php if(date('Y-m-d') >= $startSubtask && date('Y-m-d') <= $endSubtask): ?>
                  <?php if($todaySubtask['status'] != 0): ?><span class="color-<?= $todaySubtask['status'] ?>"><?= __("※このサブタスクは完了しています") ?></span><?php endif ?>
                <?php elseif(date('Y-m-d H:i:s') <= $startSubtask): ?>
                    <?= __("※まだ開始期間にはいっていません") ?>
                <?php else: ?>
                  <?php if($todaySubtask['status'] == 1): ?>
                    <span class="color-<?= $todaySubtask['status'] ?>"><?= __("※このサブタスクは完了しています") ?></span>
                  <?php else: ?>
                    <span class="limitOver"><?= __("※期限が切れています。延長するか、サブタスクを終わらせてください") ?></span>
                  <?php endif ?>
                <?php endif ?>
                  <p><span class="font-14 color-<?= $todaySubtask['status']?>"><?= $startSubtask.$startWeek.__('〜').$endSubtask.$endWeek ?></span>
                </li>
              <?php endforeach ?>
            </ul>
          <?php endforeach ?>
        </div>
      </ul>
    </div>
  </div>
  <hr class="today-plan-hr">
  <div class="row text-center">
    <div class="col-md-4">
      <div class="box box-todo">
        <h2><?= __('ToDo') ?></h2>
        <?= $this->Html->link(__('ToDoの登録'), ['controller' => 'Plans', 'action' => 'add', $result['user_id']]); ?>
        <hr>
        <div class="pad-20">
          <?php $todoCount = 0; ?>
          <ul>
            <div class="text-left">
            <?php foreach($plans as $plan): ?>
              <?php if($plan['status'] != 1): ?>
                <li>
                  <?php for($i=0; $plan['weight'] > $i; $i++){ echo "★"; } ?>
                  <span class="font-20"><?= $plan['todo'] ?></span>
                  <?= $this->Html->link(__('設定(ToDoへ変更する)'), ['controller' => 'Plans','action' => 'edit',$plan['id']]); ?>
                </li>
                <?php $todoCount++; ?>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
          <?php $todoCount == 0 ? print '<p>ToDoを登録してみましょう！</p>' : ''; ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-task">
        <h2><?= __('タスク') ?></h2>
        <?= $this->Html->link(__('タスクの登録'), ['controller' => 'Tasks', 'action' => 'add', $result['user_id']]); ?>
        <hr>
        <div class="pad-20">
          <?php $taskCount = 0; ?>
          <ul>
            <div class="text-left">
            <?php foreach($tasks as $task): ?>
              <?php if($task['status'] != 1): ?>
                <?php $taskCount++; ?>
                <li>
                  <?php if(isset($task['starttime']) && isset($task['endtime'])): ?>
                      <span class="font-20"><?= $task['description'] ?></span>
                      <?php for($i=0; $task['weight'] > $i; $i++){ echo "★"; } ?>
                      <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?></p>
                      <p><span class="font-14">
                        <?= $task['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['starttime']))].__('〜').$task['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['endtime']))] ?>
                      </span>
                      <?php if(date('Y-m-d') > $task['endtime']->i18nFormat('YYYY-MM-dd')): ?>
                        <p><?= __("※期限が切れています。延長してください") ?></p>
                      <?php endif ?>
                  <?php else: ?>
                    <span class="font-20"><?= $task['description'] ?></span>
                    <?php for($i=0; $task['weight'] > $i; $i++){ echo "★"; } ?>
                    <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?>
                    <p><?= __('※期限があれば「設定」より追加してください。') ?></p>
                  <?php endif ?>
                </li>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
          <?php $taskCount == 0 ? print '<p>タスクを登録してみましょう！</p>' : ''; ?>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-subtask">
        <h2><?= __('サブタスク') ?></h2>
        <?= $this->Html->link(__('サブタスクの登録'), ['controller' => 'Subtasks', 'action' => 'add', $result['user_id']]); ?>
        <hr>
        <div class="pad-20">
          <?php $subtaskCount = 0; ?>
          <ul>
            <div class="text-left">
            <?php foreach($tasks as $key => $task): ?>
              <?php if(count($task['subtasks']) != 0): ?>
                <?php if(isset(array_count_values($subList[$key])[0])): ?>
                <?php $subtaskCount++; ?>
                  <li>
                    <span class="font-20"><?= $task['description'] ?></span>
                    <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?></p>
                  </li>
                  <ul>
                    <?php foreach($task['subtasks'] as $subtask): ?>
                        <li>
                          <span class="font-14"><?= $subtask['subdescription'] ?></span>
                          <?php for($i=0; $subtask['weight'] > $i; $i++){ echo "★"; } ?>
                          <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$subtask['id']], ['class' => "status{$subtask['status']}"]); ?></p>
                          <p><span class="font-14">
                            <?= $subtask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['starttime']))].__('〜').$subtask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['endtime']))] ?>
                          </span>
                          <?php (date('Y-m-d') > $subtask['endtime']->i18nFormat('YYYY-MM-dd') && $subtask['status'] != 1) ? print '※期限が切れています。延長してください。' : ''; ?>
                        </li>
                    <?php endforeach ?>
                  </ul>
                <?php endif ?>
              <?php endif ?>
            <?php endforeach ?>
            </div>
          </ul>
          <?php $subtaskCount == 0 ? print '<p>サブタスクを登録してみましょう！</p>' : ''; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <h2><?= __('みんなの進捗度') ?></h2>
      <hr>
      <div class="row">
        <?php foreach ($activities as $activityUser): ?>
          <?php if($result['user']['id'] != $activityUser['user']['id']): ?>
          <div class="col-md-3">
            <h3 class="font-20"><?= __($activityUser['user']['nickname']).__('さん') ?></h3>
            <p class="font-16"><?= __('「').__($activityUser['theme']).__('」') ?></p>
            <span class="font-16 color-1"><?= __('進捗度'); ?></span>
            <?php
              $progressColor = ['success', 'info', 'warning', 'danger', 'striped'];
              $count = 0;
              if (isset($taskRate[$activityUser['user']['id']])) {
                print "<div class='progress'>";
                foreach($taskRate[$activityUser['user']['id']]['subtaskWeight'] as $taskName => $taskTitle) {
                  if (isset($taskTitle['closeRate'])) {
                    print "<div class='progress-bar progress-bar-".$progressColor[$count % count($progressColor)]." progress-bar-striped active' role='progressbar' style='width:".$taskTitle["closeRate"]."%;'>";
                    print __($taskName);
                    print "</div>";
                    $count++;
                  }
                }
                print "</div>";
              } else {
                print "<p>まだタスクを１つ以上完了していないです。</p>";
              }
            ?>
          </div>
          <?php endif ?>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <div class="row text-center margin-bt-50">
    <div class="col-xs-12">
      <h2><?= __('解決済みのタスク') ?></h2>
      <hr>
      <div class="endTask text-left color-1">
        <ul>
          <?php foreach($tasks as $key => $task): ?>
            <?php if($task['status'] == 1): ?>
              <li>
                <span class="font-20"><?= $task['description'] ?></span>
                <?php if(isset($task['starttime']) && isset($task['endtime'])): ?>
                  <?= $task['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['starttime']))].__("〜").$task['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($task['endtime']))] ?>
                <?php endif ?>
                <?= $this->Html->link(__('設定'), ['controller' => 'Tasks','action' => 'edit',$task['id']]); ?>
              </li>
            <?php endif ?>
            <?php if(isset(array_count_values($subList[$key])[1])): ?>
              <ul>
                <?php foreach($task['subtasks'] as $subtask): ?>
                  <?php if($subtask['status'] == 1): ?>
                    <li>
                      <span class="font-18"><?= $subtask['subdescription'] ?></span>
                      <span class="font-14">
                        <?php if(isset($subtask['starttime']) && isset($subtask['endtime'])): ?>
                          <?= $subtask['starttime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['starttime']))].__("〜").$subtask['endtime']->i18nFormat('YYYY-MM-dd').$week[date('w', strtotime($subtask['endtime']))] ?>
                        <?php endif ?>
                      </span>
                      <?= $this->Html->link(__('設定'), ['controller' => 'Subtasks','action' => 'edit',$subtask['id']], ['class' => "status{$subtask['status']}"]); ?>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          <?php endforeach ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php endif ?>
<script>
  $('#userAc').prepend($('<option>').html("---閲覧するユーザーを選択してください---").val("0").prop('selected', true));
  var selectVal = <?= json_encode($this->request->params['pass'][0]); ?>;
  $('#userAc').val(selectVal);

  var url = <?= json_encode($this->Url->build(['controller' => 'Admins', 'action' => 'activities'])); ?>;

  // セレクトされたユーザーのページへ遷移する
  $('[name=users]').on('change', function(){
    window.location.href = url + "/" + $('[name=users]').val();
  });
</script>
