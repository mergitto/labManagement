<div class="float-none form small-12 medium-8 large-9 columns">
  <?= $this->Form->create($attachment, [
        'type' => 'file',
      ]);
  ?>
    <fieldset>
      <legend><?= __('ファイル編集'); ?></legend>
      <?= $this->Form->input('title',['type' => 'text']); ?>
      <?= $this->Form->input('file',['type' => 'file','label' => 'ファイル']) ?>
      <?= __('※ファイルのサイズは2000KBまでにしてください') ?>
      <div class="form-group">
            <?= $this->Form->input('file_dir',['type'=>'hidden']); ?>
      </div>
      <?= $this->Form->input('url'); ?>
    </fieldset>
  <div class="login-button text-right">
    <?= $this->Form->button(__('更新する'),['class' => 'btn btn-raised btn-success']) ?>
  </div>
  <?= $this->Form->end(); ?>
</div>