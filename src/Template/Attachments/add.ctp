<div class="float-none form small-12 medium-8 large-9 columns">
  <?= $this->Form->create('Attachment', [
        'type' => 'file',
      ]);
  ?>
    <fieldset>
      <legend><?= __('ファイル追加'); ?></legend>
      <?= $this->Form->input('title'); ?>
      <?= $this->Form->input('file',['type' => 'file','label' => 'ファイル']) ?>
      <?= __('※ファイルのサイズは2000KBまでにしてください') ?>
      <div class="form-group">
            <?= $this->Form->input('file_dir',['type'=>'hidden']); ?>
      </div>
      <?= $this->Form->input('url'); ?>
      <?= $this->Form->input('user_id', ['type' => 'hidden' ,'value' => $user['id'] ]); ?>
      <?= $this->Form->input('event_id',['type' => 'hidden','value' =>  $event->id ]); ?>
    </fieldset>
  <?= $this->Form->button(__('アップロード')); ?>
  <?= $this->Form->end(); ?>
</div>