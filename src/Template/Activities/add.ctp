<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('行動計画ページに戻る'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="activities form large-9 medium-8 columns content">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('研究テーマを設定する') ?></legend>
        <div class="row">
          <div class="form-group col-xs-12">
            <?= $this->Form->input('theme', ['label' => '研究テーマ', 'type' => 'text', 'class' => 'form-control']); ?>
          </div>
        </div>
        <?= $this->Form->input('user_id', ['type' => 'hidden' ,'value' => $user['id']]); ?>
    </fieldset>
    <div class="text-right">
      <?= $this->Form->button(__('設定する'), ['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
