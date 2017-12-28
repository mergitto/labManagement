<?= $this->Html->css("markdown/github.css") ?>
<?= $this->Html->css("markdown/github-edit.css") ?>
<?= $this->Html->css("markdown/editor.css") ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('スレッド一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="row">
  <div class="posts form large-9 medium-8 columns content">
      <?= $this->Form->create($post, ['url' => [
      'action' => 'posts', $thread->id]]) ?>
      <fieldset>
          <legend><?= $thread->title ?></legend>
          <div class="form-group">
              <?= $this->element('commentForm') //markdown形式のコメントフォームの設置 ?>
              <?= $this->Form->input('url', ['type' => 'hidden', 'label' => '参考url','class' => 'form-control login-form']); ?>
              <?= $this->Form->input('user_id', ['type' =>
              'hidden' ,'value' => $user['id'], 'label' => 'タイトル名']); ?>
              <?= $this->Form->input('thread_id', ['type' =>
              'hidden' ,'value' => $thread->id, 'label' => 'タイトル名']); ?>
      </fieldset>
          <?php if($user['role'] == 'admin'): ?>
          <div class="form-group">
              <?= $this->Form->input('users._ids',[
                'label' => __('メール送信者(管理者用)'),
                'option' => $users,
                'multiple' => 'checkbox',
                'templates' => [
                  'nestingLabel' => "<div class='col-md-4 sendEmail'>{{hidden}}<label{{attrs}} >{{input}}{{text}}</label></div>",
                ]
              ]) ?>
          </div>
          <?php endif ?>
      <div class="login-button text-right">
        <?= $this->Form->button(__('コメントする'),['class' => 'btn btn-raised btn-success loading']) ?>
      </div>
      <?= $this->Form->end() ?>
  </div>
</div>
<div class="fu-list">
  <div class="alt-table-responsive">
    <table class="table table-hover table-striped">
        <div class="row">
          <thead>
          <tr>
              <th class="col-md-1 minWidth70"><?= __('名前'); ?></th>
              <th class="col-md-8"><?= __('コメント'); ?></th>
              <th class="col-md-2"><?= $this->Paginator->sort('modified', __('投稿時間')); ?></th>
              <th class="col-md-1"><?= __(""); ?></th>
          </tr>
          </thead>
        </div>
        <?php foreach ($posts as $post): ?>
        <?php
        // 曜日を日本語で
        $w = date('w', strtotime($post['modified']));
        ?>
        <div class="row">
        <tr>
            <?php foreach($usersList as $targetUser): ?>
                <?php if($targetUser->id === $post->user_id): ?>
                    <td class="img-50 col-md-1">
                    <p class="post-nickname"><?= $targetUser->nickname ?></p>
                    <?php if($targetUser['photo']): ?>
                            <?= $this->Html->image('/files/Users/photo/'.$targetUser['photo'],['alt' => '写真を設定してください','class' => 'img-50']) ?>
                    <?php else: ?>
                            <?= $this->Html->image('noimage.png',['class' => 'img-50']) ?>
                    <?php endif ?>
                    </td>
                <?php endif ?>
            <?php endforeach ?>
            <td class="col-md-8">
                <ul style="list-style: none; padding-left: 0px;" class="maxWidth700">
                    <li class="urlComment"><?= nl2br($post->comment) ?></li>
                    <?php if($post->url !== ''): ?>
                      <li><a href="<?= $post->url?>" target="_blank"><?= $post->url ?></a></li>
                    <?php endif ?>
                </ul>
            </td>
            <td class="col-md-2">
                <?= date('Y-m-d',strtotime($post->modified)); ?><?= $week[$w]; ?>
            </td>
            <td class="tc col-md-1">
                <?php if($post->user_id === $user['id']): ?>
                    <?= $this->Html->link(__('修正'), ['action' =>'postEdit',$post->id]); ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'postDelete', $post->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $post->id)]) ?>
                <?php endif ?>

            </td>
        </tr>
        </div>
        <?php endforeach ?>
    </table>
  </div>
</div>
<div class="posts index large-9 medium-8 columns content">
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
<?php if($user['role'] == 'admin'): ?>
<div id="loader-bg">
  <div id="loader">
    <?= $this->Html->image('loading-circle.svg', ['alt' => '送信中', 'class' => 'img-100']) ?>
    <p><?= __('メール送信中...') ?></p>
  </div>
</div>
<?php endif ?>
<script>
    items = $('.sendEmail').find('input');
    $(items).prop('checked', true);
</script>
<?= $this->Html->script('url2link.js') ?>
<?= $this->Html->script('markdown/highlight.js') ?>
<?= $this->Html->script('markdown/marked.js') ?>
<?= $this->Html->script('markdown/editor.js') ?>
