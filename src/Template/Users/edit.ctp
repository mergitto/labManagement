<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('本当に削除してよろしいですか # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('管理者一覧'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('新規管理者'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('ユーザー編集') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('password');
            echo $this->Form->input('admins_id', ['options' => $admins]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('更新する')) ?>
    <?= $this->Form->end() ?>
</div>
