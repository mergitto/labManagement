<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('管理者一覧へ'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('新規管理者'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['controller' => 'Users' ,'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('ユーザーを追加する') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('password');
            echo $this->Form->input('admins_id',['value' => $loginAdmin['id'], 'type' => 'hidden']);
            echo $this->Form->input('role',['type' => 'hidden', 'value' => 'user'])
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録')) ?>
    <?= $this->Form->end() ?>
</div>
