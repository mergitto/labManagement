<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('タグの新規作成'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tags index large-9 medium-8 columns content">
    <h3><?= __('タグ一覧') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category', ['labels' => 'カテゴリー']) ?></th>
                <th scope="col" class="actions"><?= __('操作') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?= $this->Number->format($tag->id) ?></td>
                <td><?= $tag->category ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('修正'), ['action' => 'edit', $tag->id]) ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $tag->id], ['confirm' => __('削除してもいいですか?', $tag->id)]) ?>
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
        <p><?= $this->Paginator->counter(['format' => __('{{pages}}ページ中の{{page}}ページ目, 全部で{{count}}件中の{{current}}件分を表示')]) ?></p>
    </div>
</div>
