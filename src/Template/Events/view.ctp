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
	<h1 class="inline-block"><?= __('Event'); ?> - </h1>
	<ul class="inline-list">
		<li><?= $this->Html->link(__('Edit Event', true), ['action' => 'edit', $event->id]); ?> </li>
		<li><?= $this->Html->link(__('Manage Events', true), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('Add an Event', true), ['action' => 'add']); ?></li>
	</ul>
	<h2><?= $event->title; ?></h2>
	<h3><?= $event->start; ?></h3>
	<p>
		<span><?= __('EVENT DETAILS: '); ?></span>
	</p>
	<p>
		<?= $event->details; ?>
	</p>
	<p>
		<span><?= __('DATE: '); ?></span>
		<?php if($event->all_day != 1): ?>
			<?= date('Y-m-d H:i:s', strtotime($event->start)) ?>
		<?php else: ?>
			<?= "N/A"; ?>
		<?php endif; ?> 
	</p>
</div>