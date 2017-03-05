<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('新規ユーザー'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('管理者一覧'), ['controller' => 'Admins', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('ユーザー一覧') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admins_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= $user->has('admin') ? $this->Html->link($user->admin->name, ['controller' => 'Admins', 'action' => 'view', $user->admin->id]) : '' ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('詳細'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('本当に削除してよろしいですか # {0}?', $user->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('初め')) ?>
            <?= $this->Paginator->prev('< ' . __('前')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('{{page}}/{{pages}}ページ, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
