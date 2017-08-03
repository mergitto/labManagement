<div class="container pad-10p">
    <?= $this->Form->create(); ?>
    <div class="panel panel-default login-table">
        <div class="panel-body">
          <h2 class="login-title"><?= __('ゼミ管理システム') ?></h2>
          <hr>
          <h3><?= __('ログイン') ?></h3>
          <div class="form-group text-gray">
              <?= $this->Form->input('name',['type'=>'text', 'label'=> 'ユーザー名', 'class' => "form-control login-form first-input input-lg"]); ?>
          </div>
          <div class="form-group text-gray">
              <?= $this->Form->input('password',['type'=>'password', 'label'=> 'パスワード', 'class' => "form-control login-form input-lg"]); ?>
          </div>
          <div class="login-button text-right">
              <?= $this->Form->submit('ログイン',['class' => 'btn btn-raised btn-default']);?>
          </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
<script>
  $(function(){
    $('.first-input').focus();
  });
</script>
