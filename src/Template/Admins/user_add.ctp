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
            <?= $this->Form->input('password',['type'=>'password', 'label'=> 'パスワード','placeholder' => '半角英数字で記入して下さい' ,'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('email',['type'=>'email', 'label'=> 'メールアドレス','placeholder' => 'hoge@gmail.com' ,'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('phone',['type'=>'text', 'label'=> '携帯電話番号','placeholder' => '例:000-0000-0000' ,'class' => "form-control login-form", 'maxlength' => 13]); ?>
        </div>
        <input id="lefile" name="photo" type="file" style="display:none">
        <div class="input-group">
            <span class="input-group-btn"><button type="button" class="btn btn-info" onclick="$('input[id=lefile]').click();">Browse</button></span>
            <input type="text" id="photoCover" class="form-control" placeholder="select file...">
        </div>
        <div class="file-comment">
            <ul style="list-style: none; padding-left: 0px;">
                <li><?= __('※ファイルのサイズは2000KBまでにしてください') ?></li>
                <li><?= __('※ファイルは後から追加することもできます') ?></li>
                <li><?= __('※画像の形式はjpg,png,gifにしてください') ?></li>
            </ul>
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
<?= $this->Html->script('fileselect.js') ?>