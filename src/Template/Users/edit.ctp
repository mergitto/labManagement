<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('削除'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('本当に削除してよろしいですか # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('ユーザー一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user,['type' => 'file']) ?>
    <fieldset>
        <legend><?= __('ユーザー編集') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('name',['type'=>'text', 'label'=> 'ユーザー名', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('confirm_password',['type'=>'password', 'label'=> 'パスワード確認用', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('password',['type'=>'password', 'label'=> '新しいパスワード','value' => "" , 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('email',['type'=>'email', 'label'=> 'メールアドレス' , 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('phone',['type'=>'text', 'label'=> '電話番号' , 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('photo',['type'=>'file', 'label'=> 'サムネイル']); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('photo_dir',['type'=>'hidden','value' => 'webroot/files/Users/photo/' ]); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('更新する'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>