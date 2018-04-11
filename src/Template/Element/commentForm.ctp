<div class="col-xs-6"></div>
<div class="col-xs-6"><?= __('プレビュー') ?></div>
<div class="col-xs-6">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#comment" data-toggle="tab"><?= __('コメント') ?></a></li>
    <li><a href="#markdown-sample" data-toggle="tab"><?= __('markdownサンプル') ?></a></li>
  </ul>
  <div class="tab-content markdown-margin">
    <div class="tab-pane active" id="comment">
      <?= $this->Form->textarea('comment',['type'=>'text', 'label'=> 'コメント', 'class' => "comment-area form-control login-form posts", 'id' => 'editor', 'placeholder' => 'markdown形式での入力が可能です。']);
      ?>
    </div>
    <div class="tab-pane" id="markdown-sample">
      <?= $this->element('markdownSample') ?>
    </div>
  </div>
</div>
<div class="col-xs-6">
  <div id="result"></div>
</div>
