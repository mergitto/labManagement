<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('管理者トップページ'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['controller' => 'Users' ,'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="container">
    <?= $this->Form->create($user,['type' => 'file']); ?>
    <div class="login-table">
        <legend><?= __('ユーザーを追加する') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('name',['type'=>'text', 'label'=> 'ユーザー名', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('password',['type'=>'password', 'label'=> 'パスワード', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('email',['type'=>'email', 'label'=> 'メールアドレス', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('phone',['type'=>'text', 'label'=> '携帯電話番号', 'class' => "form-control login-form", 'maxlength' => 11]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('photo',['type'=>'file', 'label'=> 'サムネイル', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('photo_dir',['type'=>'hidden']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('role',['type'=>'hidden','value' => 'user' ,'class' => "form-control login-form"]); ?>
        </div>
        <div class="login-button text-right">
            <?= $this->Form->submit('登録',['class' => 'btn btn-raised btn-success']);?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>