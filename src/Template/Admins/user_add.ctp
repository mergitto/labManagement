<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('管理者一覧へ'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('新規管理者'), ['controller' => 'Admins', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['controller' => 'Users' ,'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="container">
    <?= $this->Form->create($user); ?>
    <div class="panel panel-primary login-table">
        <div class="panel-body">
            <legend><?= __('ユーザーを追加する') ?></legend>
            <div class="form-group">
                <?= $this->Form->input('name',['type'=>'text', 'label'=> 'ユーザー名', 'class' => "form-control login-form"]); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->input('password',['type'=>'password', 'label'=> 'パスワード', 'class' => "form-control login-form"]); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->input('role',['type'=>'hidden','value' => 'user' ,'class' => "form-control login-form"]); ?>
            </div>
            <div class="login-button">
                <?= $this->Form->submit('登録',['class' => 'btn btn-raised btn-primary']);?>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>