<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="subtasks form large-9 medium-8 columns content">
    <?= $this->Form->create($subtask) ?>
    <fieldset>
        <legend><?= __('サブタスクを登録する') ?></legend>
        <?php
            echo $this->Form->input('subdescription');
            echo $this->Form->input('status');
            echo $this->Form->text('user_id', ['type' => 'hidden', 'value' => $user['id']]);
            echo $this->Form->input('starttime');
            echo $this->Form->input('endtime');
            echo $this->Form->input('weight', ['label' => '重要度', 'min' => MINPRIORITY, 'max' => MAXPRIORITY]);
            echo $this->Form->input('tasks._ids', ['options' => $tasks, 'multiple' => false]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録する')) ?>
    <?= $this->Form->end() ?>
</div>
