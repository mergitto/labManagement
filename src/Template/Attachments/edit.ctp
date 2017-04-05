<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('「'.$attachment->event->title.'」予定一覧へ戻る'), ['controller' => 'Events' ,'action' => 'view',$attachment->event->id]) ?></li>
    </ul>
</nav>
<div class="threads form large-9 medium-8 columns content　container">
  <?= $this->Form->create($attachment , [
        'type' => 'file',
      ]);
  ?>
    <fieldset>
        <legend><?= __('ファイル編集') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('title',['type'=>'text', 'label'=> 'タイトル', 'class' => "form-control login-form"]); ?>
        </div>
        <div class="form-group">
          <input id="lefile" name="file" type="file" style="display:none">
            <div class="input-group">
                <span class="input-group-btn"><button type="button" class="btn btn-info" onclick="$('input[id=lefile]').click();">Browse</button></span>
                <input type="text" id="photoCover" class="form-control" placeholder="select file...">
            </div>
        </div>
        <div class="form-group">
            <?= $this->Form->input('url',['type'=>'text', 'label'=> 'url', 'class' => "form-control login-form"]); ?>
        </div>
        <?= $this->Form->input('user_id', ['type' => 'hidden' ,'value' => $user['id'] ]); ?>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('更新'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('fileselect.js') ?>