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
          <li><?= $this->Html->link(__('管理者用の行動計画ページに戻る'), ['controller' => 'Admins', 'action' => 'activities', $subtask['user_id']]) ?></li>
        <?php else: ?>
          <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
        <?php endif ?>
    </ul>
</nav>
<div class="subtasks form large-9 medium-8 columns content">
    <?= $this->Form->create($subtask) ?>
    <fieldset>
        <legend><?= __('サブタスクを修正する') ?></legend>
        <div class="row">
          <div class="form-group col-xs-12">
            <?= $this->Form->input('subdescription', ['label' => 'サブタスクの内容', 'type' => 'text', 'class' => 'form-control']); ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-3">
            <?= $this->Form->input('weight', ['label' => '重要度（１〜５）', 'min' => MINPRIORITY, 'max' => MAXPRIORITY, 'class' => 'form-control']); ?>
          </div>
          <div class="form-group col-sm-3">
            <?= $this->Form->input('starttime',['type'=>'text', 'label'=> 'サブタスク開始日','id' => 'dp1' ,'class' => "form-control login-form"]); ?>
          </div>
          <div class="form-group col-sm-3">
            <?= $this->Form->input('endtime',['type'=>'text', 'label'=> 'サブタスク締切日','id' => 'dp2' ,'class' => "form-control login-form"]); ?>
          </div>
          <div class="form-group col-sm-3">
            <?= $this->Form->input('status', ['min' => PROCESS, 'max' => CLOSE, 'class' => 'form-control', 'label' => '0=処理中,_1=解決済みにする']); ?>
          </div>
        </div>
        <div class="row">
          <?= $this->Form->input('tasks._ids',[
            'label' => __('どのタスクに割り当てますか'),
            'option' => $tasks,
            'multiple' => 'checkbox',
            'templates' => [
              'nestingLabel' => "<div class='col-md-4'>{{hidden}}<label{{attrs}} >{{input}}{{text}}</label></div>",
            ]
          ]) ?>
        </div>
        <?= $this->Form->text('user_id', ['type' => 'hidden', 'value' => $subtask['user_id']]); ?>
    </fieldset>
    <div class="text-right">
      <?= $this->Form->button(__('修正する'), ['class' => 'btn btn-raised btn-success']) ?>
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
