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
        <legend><?= __('サブタスクを修正する') ?></legend>
        <?php
            echo $this->Form->input('subdescription');
            echo $this->Form->input('status');
            echo $this->Form->text('user_id', ['type' => 'hidden', 'value' => $user['id']]);
            echo $this->Form->input('starttime');
            echo $this->Form->input('endtime');
            echo $this->Form->input('weight');
            echo $this->Form->input('tasks._ids', ['options' => $tasks]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('修正する')) ?>
    <?= $this->Form->end() ?>
</div>
