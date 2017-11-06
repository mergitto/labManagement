<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->css('classic.css') ?>
<?= $this->Html->css('classic.date.css') ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if ($user['role'] === 'admin'): ?>
          <li><?= $this->Html->link(__('管理者用の行動計画ページに戻る'), ['controller' => 'Admins', 'action' => 'activities', $activityUserId]) ?></li>
        <?php else: ?>
          <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
        <?php endif ?>
    </ul>
</nav>
<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __('タスクを登録する') ?></legend>
        <div class="row">
          <div class="form-group col-xs-12">
            <?= $this->Form->input('description', ['label' => 'タスク内容', 'type' => 'text', 'class' => 'form-control']); ?>
          </div>
        </div>
        <div class="row">
          <?= $this->Form->input('status', ['type' => 'hidden', 'value' => 0, 'min' => PROCESS, 'max' => CLOSE, 'class' => 'form-control']); ?>
          <div class="form-group col-sm-3 col-sm-offset-3">
            <?= $this->Form->input('weight', ['label' => '重要度（１〜５）', 'min' => MINPRIORITY, 'max' => MAXPRIORITY, 'class' => 'form-control']); ?>
          </div>
          <?= $this->Form->text('user_id', ['type' => 'hidden', 'value' => $activityUserId]); ?>
          <div class="form-group col-sm-3">
            <?= $this->Form->input('starttime',['type'=>'text', 'label'=> 'タスク開始日','id' => 'dp1' ,'class' => "form-control login-form"]); ?>
          </div>
          <div class="form-group col-sm-3">
            <?= $this->Form->input('endtime',['type'=>'text', 'label'=> 'タスク締切日','id' => 'dp2' ,'class' => "form-control login-form"]); ?>
          </div>
        </div>
    </fieldset>
    <div class="text-right">
      <?= $this->Form->button(__('登録する'), ['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('picker.js') ?>
<?= $this->Html->script('picker.date.js') ?>
<?= $this->Html->script('legacy.js') ?>
<script>
$(function(){
  $('#dp1').pickadate({
    format: 'yyyy-mm-dd'
  });
  $('#dp2').pickadate({
    format: 'yyyy-mm-dd'
  });
});
</script>
