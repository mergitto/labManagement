<!-- モーダルウィンドウの中身 -->
<div class="modal fade" id="taskModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?=$user['nickname'].__("さんの本日のタスク・サブタスク") ?></h4>
      </div>
      <div class="modal-body">
        <ul class="modal-list">
          <?php
            if($this->request->params['controller'] == 'Events') {
              $myTodayTasks = $todayTasks;
            } else {
              $myTodayTasks = $this->viewVars['todayTasks'];
            }
          ?>
          <?php if ($myTodayTasks->isEmpty()): ?>
            <?= __("本日のタスクはありません。") ?>
          <?php else: ?>
            <?php foreach($myTodayTasks as $todayTask): ?>
            <li>
              <?= $todayTask['description']."  ".$todayTask['starttime']->i18nFormat("YYYY-MM-dd").$week[date('w', strtotime($todayTask['starttime']))]."~".$todayTask['endtime']->i18nFormat("YYYY-MM-dd") .$week[date('w', strtotime($todayTask['endtime']))] ?>
              <ul>
                <?php foreach($todayTask['subtasks'] as $subtask): ?>
                  <?php if ($subtask['starttime']->i18nFormat("YYYY-MM-dd") <= date('Y-m-d') && $subtask['endtime']->i18nFormat("YYYY-MM-dd") >= date('Y-m-d')): // その日のサブタスクのみ表示する ?>
                  <li><?= $subtask['subdescription']."  ".$subtask['starttime']->i18nFormat("YYYY-MM-dd").$week[date('w', strtotime($subtask['starttime']))]."~".$subtask['endtime']->i18nFormat("YYYY-MM-dd") .$week[date('w', strtotime($subtask['endtime']))] ?></li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            </li>
            <?php endforeach ?>
          <?php endif ?>
        </ul>
      </div>
      <div class="modal-footer">
        <?php if ($userFlag['task_modal_flg'] == 0): ?>
          <div class="text-left"><label><input type="checkbox" name="modal-flag" value="<?= $user['id'] ?>"><?= __("この通知を一日中表示しないようにする"); ?></label><span id="update-flg"><?= __("※正常に更新されました") ?></span></div>
          <button type="button" class="btn btn-success flg-update"><?= __("更新") ?></button>
        <?php endif ?>
        <button type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>
<!-- モーダルウィンドウのスクリプト -->
<?= $this->Html->script('taskModalShow.js'); ?>
