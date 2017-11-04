<?php
/**
  * @var \App\View\AppView $this
  */
?>
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
        <?php
            echo $this->Form->input('description');
            echo $this->Form->input('status', ['min' => PROCESS, 'max' => CLOSE]);
            echo $this->Form->input('weight', ['label' => '重要度', 'min' => MINPRIORITY, 'max' => MAXPRIORITY]);
            echo $this->Form->text('user_id', ['type' => 'hidden', 'value' => $activityUserId]);
            echo $this->Form->input('starttime');
            echo $this->Form->input('endtime');
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録する')) ?>
    <?= $this->Form->end() ?>
</div>
