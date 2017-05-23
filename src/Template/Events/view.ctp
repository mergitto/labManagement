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
echo $this->Html->css('star-rating.css');
echo $this->Html->css('theme.css');

$w = date('w', strtotime($event->start));
?>
<div class="small-12 columns">
	<ul class="inline-list">
		<li><?= $this->Html->link(__('ゼミ予定一覧', true), ['action' => 'index']); ?> </li>
	</ul>
	<blockquote class="blockquote text-left">
		<h3><?= $event->title; ?></h3>
		<p class="font-14 text-muted"><i class="glyphicon glyphicon-menu-right"></i><?= date('Y-m-d', strtotime($event->start)) ?><?= $week[$w]; ?></p>
	</blockquote>
	<h3><?=  __("ゼミ担当") ?></h3>
	<h4>
	<?php foreach($event->users as $eventUsers): ?>
		<?php if(array_search($eventUsers->name, $checkUsers) === FALSE): ?>
			<span class="text-muted"><?= $eventUsers->name.__('/') ?></span>
		<?php else: ?>
			<span class="text-primary font-b"><?= $eventUsers->name.__('/') ?></span>
		<?php endif?>
	<?php endforeach ?>
	</h4>
	<?= $this->Html->link(__('ファイルを登録する'),['controller' => 'Attachments', 'action' => 'add', $event->id]) ?>
	<p>
		<h3><?= __('詳細') ?></h3>
		<span class="text-muted"><?= nl2br($event->details); ?></span>
	</p>
	<div class="fu-frame-main">
	    <div class="container">
	        <hr class="mb0">

	        <div class="fu-list">
	            <table class="table table-hover table-striped">
	                <thead>
	                <tr>
	                		<th colspan="2"><?= __('ユーザー名'); ?></th>
	                    <th><?= $this->Paginator->sort('title', __('ゼミ資料タイトル')); ?></th>
                      <th class="mi-w-360"><?= $this->Paginator->sort('file', __('資料名')); ?></th>
                      <th class="w-500"><?= $this->Paginator->sort('url', __('参考URL')); ?></th>
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
	                    <td class="text-muted">
	                        <?= $attachment->title; ?>
													<div class="font-24">
														<?php if(array_search($user['id'],$favUser[$attachment->id])): ?>
															<span class="favChecked">
																<i class="glyphicon glyphicon-thumbs-up ajaxFav mar-le-10" data-favoId="<?= $favId[$user['id']][$attachment->id][0]?>" data-userId='<?= $user['id'] ?>' data-attachmentId='<?= $attachment->id ?>'></i>
														<?php else: ?>
															<span>
																<i class="glyphicon glyphicon-thumbs-up ajaxFav mar-le-10" data-userId='<?= $user['id'] ?>' data-attachmentId='<?= $attachment->id ?>'></i>
														<?php endif ?>
														</span>
													</div>
                      </td>
	                    <td>
                          <?= $this->Html->link(__($attachment->tmp_file_name),['controller' => 'Attachments', 'action' => 'download',$attachment->file]) ?>
                          <i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>
													<div class="scoreChecked">
														<?php $checkScore = 0; ?>
														<?php foreach($attachment->scores as $score): ?>
															<?php if($score->user_id == $user['id'] && $score->attachment_id == $attachment->id):?>
																<input id="score" name="score"  class="ajaxScore rating rating-loading" value='<?= $score->score ?>' data-min="0" data-max="5" data-step="1" data-size="xs" data-userId="<?= $user['id'] ?>" data-scoreId="<?= $score->id?>" data-attachmentId="<?= $attachment->id ?>" data-score-selected="true">
																<?php $checkScore = 1;?>
															<?php endif ?>
													<?php endforeach ?>
													<?php if($checkScore != 1): ?>
														<input id="score" name="score"  class="ajaxScore rating rating-loading" value='0' data-min="0" data-max="5" data-step="1" data-size="xs" data-userId="<?= $user['id'] ?>" data-attachmentId="<?= $attachment->id ?>" data-score-selected="false">
													<?php endif ?>
													</div>
													<ul class="list-inline" style="list-style: none;">
														<?php foreach($attachment->tags as $tag): ?>
															<li><span class="label label-success"><?= $tag['category'] ?><span class="badge"><?= $tagCount[$tag['category']] ?></span></span></li>
														<?php endforeach?>
													</ul>
                      </td>
                      <td>
                      <?php if($attachment->url !== ''): ?>
                          <?= $this->Html->link($attachment->url) ?>
                      <?php endif ?>
                      </td>
	                    <td class="tc">
	                        <?= $this->Html->link(__('編集'), ['controller' => 'Attachments' ,'action' =>'edit',$attachment->id]); ?>
	                        <?= $this->Form->postLink(__('削除'), ['controller' => 'Attachments' ,'action' => 'delete', $attachment->id ], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $attachment->tmp_file_name)]) ?>
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
<?= $this->Html->script('star-rating.js'); ?>
<?= $this->Html->script('theme.js'); ?>
<?= $this->Html->script('favChecked.js'); ?>
<script>
	$(function(){
		$('.glyphicon-star').click(function(){
		  var $checked = $(this).closest('.scoreChecked');
		  var captionText = $checked.find('.caption').text();
		  var score = parseFloat(captionText.replace(/[^-^0-9^\.]/g,""));
		  $.ajax({
		      url: "/labManagement/Scores/scoreAjax",
		      type: "POST",
		      data: {
		        user_id: $checked.find('.ajaxScore').attr('data-userId'),
		        attachment_id: $checked.find('.ajaxScore').attr('data-attachmentId'),
		        score: score,
		        score_id: $checked.find('.ajaxScore').attr('data-scoreId'),
		        scoreFlag: $checked.find('.ajaxScore').attr('data-score-selected'),
		      },
		      context: this,
		      dataType: "json",
		  }).done(function(data,context){
		    if(data['scoreFlag'] == 'false'){
		      $(this).closest('.scoreChecked').find('.ajaxScore').attr('data-score-selected','true');
		      $(this).closest('.scoreChecked').find('.ajaxScore').attr('data-scoreId',data['score_id']);
		    }
		  }).fail(function(){
		    console.log("failed");
		  });
		});
	});
</script>
