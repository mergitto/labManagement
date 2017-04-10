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
// 曜日を日本語で
$w = date('w', strtotime($event->start));
?>

<div class="small-12 columns">
	<ul class="inline-list">
		<li><?= $this->Html->link(__('ゼミ予定一覧', true), ['action' => 'index']); ?> </li>
	</ul>
	<blockquote class="blockquote text-left">
		<h3><?= $event->title; ?></h3>
	</blockquote>
	<h3><?= __('日付: '); ?><?= date('Y-m-d', strtotime($event->start)) ?><?= $week[$w]; ?></h3>
	<p>
		<span><?= __('詳細: '); ?></span>
		<?= nl2br($event->details); ?>
	</p>
	<?= $this->Html->link(__('ファイルを登録する'),['controller' => 'Attachments', 'action' => 'add', $event->id]) ?>
	<div class="fu-frame-main">
	    <div class="container">
	        <hr class="mb0">

	        <div class="fu-list">
	            <table class="table table-hover">
	                <thead>
	                <tr>
	                		<th colspan="2"><?= __('ユーザー名'); ?></th>
	                    <th><?= $this->Paginator->sort('title', __('ゼミ資料タイトル')); ?></th>
                        <th><?= $this->Paginator->sort('file', __('資料名')); ?></th>
                        <th><?= $this->Paginator->sort('url', __('URL')); ?></th>
	                    <th class="b_w150">　</th>
	                </tr>
	                </thead>
	                <?php foreach ($attachments as $attachment): ?>
	                <tr>
		                <td class="img-50">
	                    <?php if($attachment->user->photo): ?>
	                            <?= $this->Html->image('/files/Users/photo/'.$attachment->user->photo,['alt' => '写真を設定してください','class' => 'img-50']) ?>
	                    <?php else: ?>
	                            <?= $this->Html->image('noimage.png',['class' => 'img-50']) ?>
	                    <?php endif ?>
	                    </td>
                        <td>
                            <?= $attachment->user->name ?>
                        </td>
	                    <td>
	                        <?= $attachment->title; ?>
                        </td>
	                    <td>
                            <?= $this->Html->link(__($attachment->file),['controller' => 'Attachments', 'action' => 'download',$attachment->file]) ?>
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </td>
                        <td>
                        <?php if($attachment->url !== ''): ?>
                            <?= $this->Html->link($attachment->url) ?>
                        <?php endif ?>
                        </td>
	                    <td class="tc">
	                        <?= $this->Html->link(__('編集'), ['controller' => 'Attachments' ,'action' =>'edit',$attachment->id]); ?>
	                        <?= $this->Form->postLink(__('削除'), ['controller' => 'Attachments' ,'action' => 'delete', $attachment->id ], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $attachment->file)]) ?>
	                    </td>
	                </tr>
	                <?php endforeach ?>
	            </table>
	        </div>
	    </div>
	</div>
	<!-- / .fu-frame-main -->
	<div class="users index large-9 medium-8 columns content">
	    <div class="paginator">
	        <ul class="pagination">
	            <?= $this->Paginator->first('<< ' . __('初め')) ?>
	            <?= $this->Paginator->prev('< ' . __('前')) ?>
	            <?= $this->Paginator->numbers() ?>
	            <?= $this->Paginator->next(__('次') . ' >') ?>
	            <?= $this->Paginator->last(__('最後') . ' >>') ?>
	        </ul>
	        <p><?= $this->Paginator->counter(['format' => __('{{page}}/{{pages}} ページ目,　{{count}}　人中 {{current}} 人表示')]) ?></p>
	    </div>
	</div>
</div>
