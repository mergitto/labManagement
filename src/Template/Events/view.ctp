<?php
/*
 * Template/Events/view.ctp
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
?>

<div class="small-12 columns">
	<h1 class="inline-block"><?= __('ゼミ予定詳細'); ?></h1>
	<ul class="inline-list">
		<li><?= $this->Html->link(__('ゼミ予定編集', true), ['action' => 'edit', $event->id]); ?> </li>
		<li><?= $this->Html->link(__('ゼミ予定一覧', true), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('ゼミ予定追加', true), ['action' => 'add']); ?></li>
	</ul>
	<h2><?= $event->title; ?></h2>
	<h3><?= $event->start; ?></h3>
	<p>
		<span><?= __('詳細: '); ?></span>
		<?= $event->details; ?>
	</p>
	<p>
		<span><?= __('日付: '); ?></span>
		<?php if($event->all_day != 1): ?>
			<?= date('Y-m-d', strtotime($event->start)) ?>
		<?php else: ?>
			<?= "N/A"; ?>
		<?php endif; ?> 
	</p>
	<p>
		<?php foreach($attachments as $attachment): ?>
			<?= $attachment->title ?>
		<?php endforeach ?>
	</p>
</div>
<div class="float-none form small-12 medium-8 large-9 columns">
	<?= $this->Form->create('Attachment', [
				'type' => 'file',
				'type' => 'post',
				'url' => ['controller' => 'Attachments', 'action' => 'add']
			]);
	?>
		<fieldset>
	 		<legend><?= __('ファイル追加'); ?></legend>
			<?= $this->Form->input('title'); ?>
			<?= $this->Form->input('filename',['type' => 'file','label' => 'ファイル']) ?>
			<?= $this->Form->input('url'); ?>
			<?= $this->Form->input('type'); ?>
			<?= $this->Form->input('contents'); ?>
			<?= $this->Form->input('user_id', ['type' => 'hidden' ,'value' => $user['id'] ]); ?>
			<?= $this->Form->input('event_id',['type' => 'hidden','value' =>  $event->id ]); ?>
		</fieldset>
	<?= $this->Form->button(__('アップロード')); ?>
	<?= $this->Form->end(); ?>
</div>