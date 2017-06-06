<div class="container pad-10p">
    <?= $this->Form->create(); ?>
    <div class="panel panel-default login-table">
        <div class="panel-heading">
            <h3 class="panel-title">ログイン</h3>
        </div>
        <div class="panel-body">
        <div class="form-group">
            <?= $this->Form->input('name',['type'=>'text', 'label'=> 'ユーザー名', 'class' => "form-control login-form first-input"]); ?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('password',['type'=>'password', 'label'=> 'パスワード', 'class' => "form-control login-form"]); ?>
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
