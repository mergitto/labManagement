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
 // 曜日を日本語で
 $w = date('w', strtotime($event->start));
?>
<?= $this->Html->css('classic.css') ?>
<?= $this->Html->css('classic.date.css') ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('予定一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="threads form large-9 medium-8 columns content　container">
    <?= $this->Form->create($event) ?>
    <fieldset>
        <legend><?= __('ゼミ予定編集') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('title',['type'=>'text', 'label'=> 'タイトル', 'class' => "form-control login-form"]); ?>
            <?= $this->Form->input('details',['type'=>'textarea', 'label'=> 'ゼミ詳細', 'class' => "form-control login-form"]); ?>
            <div class="row">
            	<div class="col-md-6">
            <?= $this->Form->input('start',['type'=>'text', 'label'=> 'ゼミ予定日','id' => 'dp1' ,'class' => "form-control login-form",'value' =>  date(__('Y-m-d'),strtotime($event->start))]); ?>
            	</div>
            </div>
            <?= $this->Form->input('user_id', ['type' =>
            'hidden' ,'value' => $user['id']]); ?>
            <?= $this->Form->input('all_day',['type' => 'hidden']); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('更新'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
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
