<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?= $this->Html->css("markdown/github.css") ?>
<?= $this->Html->css("markdown/github-edit.css") ?>
<?= $this->Html->css("markdown/editor.css") ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('コメント一覧'), ['action' => 'posts',$post->thread_id]) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('コメント修正') ?></legend>
        <div class="row">
          <?= $this->element('commentForm') // markdown形式のコメントフォームの設置?>
        </div>
        <div class="form-group">
            <?= $this->Form->input('url',['type'=>'hidden', 'label'=> 'コメント', 'class' => "form-control login-form"]); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('更新する'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<?= $this->Html->script('markdown/highlight.js') ?>
<?= $this->Html->script('markdown/marked.js') ?>
<?= $this->Html->script('markdown/editor.js') ?>
