<?php
/*
 * Template/Events/edit.ctp
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
		<li><?= $this->Html->link(__('View Event', true), ['action' => 'view', $event->id]); ?></li>
		<li><?= $this->Html->link(__('Manage Events', true), ['action' => 'index']);?></li>
		<li><?= $this->Html->link(__('Add an Event', true), ['action' => 'add']); ?></li>
	</ul>
</div>
<div class="float-none form small-12 medium-8 large-9 columns">
	<?= $this->Form->create($event, ['type' => 'file']);?>
		<fieldset>
	 		<legend><?= __('Edit Event'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('title');
			echo $this->Form->input('details');
			echo $this->Form->input('start',['type' => 'text', 'id' => 'dp1', 'value' => date('Y-m-d',strtotime($event->start))]);
			echo $this->Form->input('status', ['options' => [
						'Scheduled' => 'Scheduled','Confirmed' => 'Confirmed','In Progress' => 'In Progress',
						'Rescheduled' => 'Rescheduled','Completed' => 'Completed'
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