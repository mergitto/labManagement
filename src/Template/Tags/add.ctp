<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('タグリスト一覧へ'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="tags form large-9 medium-8 columns content">
    <?= $this->Form->create($tag) ?>
    <fieldset>
        <legend><?= __('タグ名を追加') ?></legend>
        <?php
            echo $this->Form->input('category', ["type" => "text", "label" => "タグ名"]);
            echo $this->Form->input('user_id', ["type" => "hidden", "value" => $user['id']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('追加する')) ?>
    <?= $this->Form->end() ?>
</div>
