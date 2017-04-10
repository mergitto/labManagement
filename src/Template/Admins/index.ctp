<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('ユーザー一覧'), ['controller' => 'users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('ユーザー新規登録'), ['action' => 'user_add'] ) ?></li>
    </ul>
</nav>
<div class="admins index large-9 medium-8 columns content">
    <table cellpadding="0" cellspacing="0">
        <tbody>
            <?php foreach ($admins as $admin): ?>
            <tr>
                <td><?= $this->Number->format($admin->id) ?></td>
                <td><?= h($admin->name) ?></td>
                <td><?= h($admin->created) ?></td>
                <td><?= h($admin->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('詳細'), ['action' => 'view', $admin->id]) ?>
                    <?= $this->Html->link(__('編集'), ['action' => 'edit', $admin->id]) ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $admin->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $admin->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
