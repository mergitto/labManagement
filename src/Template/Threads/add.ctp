<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('タイトル一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="threads form large-9 medium-8 columns content">
    <?= $this->Form->create($thread) ?>
    <fieldset>
        <legend><?= __('タイトル追加') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('title',['type'=>'text', 'label'=> 'タイトル', 'class' => "form-control login-form"]); ?>
            <?= $this->Form->input('user_id', ['type' => 
            'hidden' ,'value' => $user['id'], 'label' => 'タイトル名']); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('新規登録'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
