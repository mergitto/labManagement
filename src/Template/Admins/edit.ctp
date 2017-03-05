<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('削除する'),
                ['action' => 'delete', $admin->id],
                ['confirm' => __('本当に削除してよろしいですか # {0}?', $admin->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('管理者一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="admins form large-9 medium-8 columns content">
    <?= $this->Form->create($admin) ?>
    <fieldset>
        <legend><?= __('管理者編集') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('更新する')) ?>
    <?= $this->Form->end() ?>
</div>
