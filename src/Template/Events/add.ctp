<?php
/*
 * Template/Events/add.ctp
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
?>
<?= $this->Html->css('classic.css') ?>
<?= $this->Html->css('classic.date.css') ?>
<div class="actions small-12 medium-4 large-3 columns">
	<h4>Actions</h4>
	<ul class="no-bullet">
		<li><?= $this->Html->link(__('予定一覧', true), ['action' => 'index']);?></li>
	</ul>
</div>
<div class="float-none form small-12 medium-8 large-9 columns">
<?= $this->Form->create($event);?>
	<fieldset>
 		<legend><?= __('Add Event'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('details');
		echo $this->Form->input('start',['type' => 'text', 'id' => 'dp1']);
		echo $this->Form->input('all_day',['type' => 'hidden']);
		echo $this->Form->input('user_id',['value' => $user['id'], 'type' => 'hidden']);
		echo $this->Form->input('status', ['options' => [
					'Scheduled' => __('Scheduled'),'Confirmed' => __('Confirmed'),'In Progress' => __('In Progress'),
					'Rescheduled' => __('Rescheduled'),'Completed' => __('Completed')
				]
			]
		);
	?>
	</fieldset>
<?= $this->Form->button(__('Submit', true));?>
<?= $this->Form->end(); ?>
</div>
<?= $this->Html->script('picker.js') ?>
<?= $this->Html->script('picker.date.js') ?>
<?= $this->Html->script('legacy.js') ?>
<script>
	$(function(){
		$('#dp1').pickadate({
  		format: 'yyyy-mm-dd'
		});
	});
</script>