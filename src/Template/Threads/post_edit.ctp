<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('削除'),
                ['action' => 'postDelete', $post->user_id],
                ['confirm' => __('本当に削除してよろしいですか # {0}?', $post->user_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('コメント一覧'), ['action' => 'posts']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('コメント修正') ?></legend>
        <div class="form-group">
            <?= $this->Form->textarea('comment',['type'=>'text', 'label'=> 'コメント', 'class' => "form-control login-form"]); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('更新する'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>