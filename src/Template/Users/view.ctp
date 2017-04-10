<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('ユーザー編集'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('ユーザー削除'), ['action' => 'delete', $user->id], [__('本当に削除してよろしいですか # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('管理者一覧'), ['controller' => 'Admins', 'action' => 'index']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('管理者名') ?></th>
            <td><?= $user->has('admin') ? $this->Html->link($user->admin->name, ['controller' => 'Admins', 'action' => 'view', $user->admin->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('作成日') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新日') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('ユーザー名') ?></h4>
        <?= $this->Text->autoParagraph(h($user->name)); ?>
    </div>
    <div class="row">
        <h4><?= __('パスワード') ?></h4>
        <?= $this->Text->autoParagraph(h($user->password)); ?>
    </div>
</div>
