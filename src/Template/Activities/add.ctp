<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('行動計画ページに戻る'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="activities form large-9 medium-8 columns content">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('研究テーマを設定する') ?></legend>
        <?= $this->Form->input('theme', ['label' => '研究テーマ']); ?>
        <?= $this->Form->input('user_id', ['type' => 'hidden' ,'value' => $user['id']]); ?>
    </fieldset>
    <?= $this->Form->button(__('設定する')) ?>
    <?= $this->Form->end() ?>
</div>
