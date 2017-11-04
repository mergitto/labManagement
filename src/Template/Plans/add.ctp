<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <?php if ($user['role'] === 'admin'): ?>
          <li><?= $this->Html->link(__('管理者用の行動計画ページに戻る'), ['controller' => 'Admins', 'action' => 'activities', $activity['user_id']]) ?></li>
        <?php else: ?>
          <li><?= $this->Html->link(__('行動計画ページに戻る'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
        <?php endif ?>
    </ul>
</nav>
<div class="plans form large-9 medium-8 columns content">
    <?= $this->Form->create($plan) ?>
    <fieldset>
        <legend><?= __('ToDoを登録する') ?></legend>
        <?php
            echo $this->Form->input('todo');
            echo $this->Form->input('weight', ['label' => '重要度', 'min' => MINPRIORITY, 'max' => MAXPRIORITY]);
            echo $this->Form->input('status', ['type' => 'hidden', 'label' => '状態(0=ToDo, 1=タスクへ移動する)']);
            echo $this->Form->text('activity_id', ['type' => 'hidden', 'label' => $activity['theme'], 'value' => $activity['id']])
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録する')) ?>
    <?= $this->Form->end() ?>
</div>
