<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('管理者一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="admins form large-9 medium-8 columns content">
    <?= $this->Form->create($admin) ?>
    <fieldset>
        <legend><?= __('管理者登録') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__('登録する')) ?>
    <?= $this->Form->end() ?>
</div>
