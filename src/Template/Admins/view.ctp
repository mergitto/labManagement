<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('編集する'), ['action' => 'edit', $admin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('削除する'), ['action' => 'delete', $admin->id], ['confirm' => __('本当に削除してよろしいですか # {0}?', $admin->id)]) ?> </li>
        <li><?= $this->Html->link(__('管理者一覧'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新規管理者'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="admins view large-9 medium-8 columns content">
    <h3><?= h($admin->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($admin->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('作成日') ?></th>
            <td><?= h($admin->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新日') ?></th>
            <td><?= h($admin->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('管理者名') ?></h4>
        <?= $this->Text->autoParagraph(h($admin->name)); ?>
    </div>
    <div class="row">
        <h4><?= __('パスワード') ?></h4>
        <?= $this->Text->autoParagraph(h($admin->password)); ?>
    </div>
</div>
