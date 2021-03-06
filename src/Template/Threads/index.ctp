<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="threads index large-9 medium-8 columns content container">
    <div class="row row-eq-height">
        <div class="col-xs-12">
            <h3><?= __('掲示板') ?></h3>
            <hr class="md10">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
          <?= $this->Html->link(__('新規タイトル'),['action' => 'add'], ['class' => 'glyphicon glyphicon-list-alt btn btn-default']) ?>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?= $this->Form->create() ?>
            <fieldset>
                <div class="form-group">
                    <?= $this->Form->input('title',[
                        'type'=>'text',
                        'label'=> __('タイトル検索'),
                        'class' => "form-control login-form",
                        'placeholder' => 'タイトル名を入力してください'
                    ]); ?>
                </div>
            </fieldset>
        </div>
        <div class="col-md-1 text-right pad-25">
            <?= $this->Form->button(__('検索'),['class' => 'glyphicon glyphicon-search btn btn-raised btn-success']) ?>
            <?= $this->Form->end() ?>
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="fu-list">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('title', __('タイトル')); ?></th>
                <th><?= __('最終更新日'); ?></th>
                <th class="b_w150">　</th>
            </tr>
            </thead>
            <?php foreach ($threads as $thread): ?>
            <?php
            // 曜日を日本語で
            $w = date('w', strtotime($thread['modified']));
            ?>
            <tr>
                <td>
                    <?= $this->Html->link($thread->title,[
                        'action' => 'posts', $thread->id
                    ]) ?>
                    <span class="text-muted">(<?= count($thread->posts); ?>)</span>
                </td>
                <td>
                    <?php if(isset($thread->posts[0]['modified'])): ?>
                      <?= date('Y-m-d', strtotime($thread->posts[0]['modified'])) ?><?= $week[date('w', strtotime($thread->posts[0]['modified']))]; ?>
                    <?php else: ?>
                      <?= date('Y-m-d', strtotime($thread['modified'])) ?>
                    <?php endif ?>
                </td>
                <td class="tc">
                <?php if($thread->user_id === $user['id']): ?>
                    <?= $this->Html->link(__('編集'), ['action' =>'edit',$thread->id]); ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $thread->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $thread['title'])]) ?>
                <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="users index large-9 medium-8 columns content">
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('初め')) ?>
                <?= $this->Paginator->prev('< ' . __('前')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('次') . ' >') ?>
                <?= $this->Paginator->last(__('最後') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('{{page}}/{{pages}} ページ目,　{{count}}　件中 {{current}} 件表示')]) ?></p>
        </div>
    </div>
</div>
