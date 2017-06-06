<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('スレッド一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="posts form large-9 medium-8 columns content">
    <?= $this->Form->create($post, ['url' => [
    'action' => 'posts', $thread->id]]) ?>
    <fieldset>
        <legend><?= __('新規コメント') ?></legend>
        <div class="form-group">
            <?= $this->Form->textarea('comment',['type'=>'text', 'label'=> 'コメント', 'class' => "form-control login-form", 'placeholder' => 'コメントを書いて投稿しましょう。参考にしたURLを貼ってみてください。']); ?>
            <?= $this->Form->input('url', ['type' => 'hidden', 'label' => '参考url','class' => 'form-control login-form','placeholder' => '参考にしたURLを貼ってみてください。なくても登録できます。']); ?>
            <?= $this->Form->input('user_id', ['type' =>
            'hidden' ,'value' => $user['id'], 'label' => 'タイトル名']); ?>
            <?= $this->Form->input('thread_id', ['type' =>
            'hidden' ,'value' => $thread->id, 'label' => 'タイトル名']); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
      <?= $this->Form->button(__('新規登録'),['class' => 'btn btn-raised btn-success glyphicon glyphicon-plus']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<div class="fu-list">
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th colspan="2"><?= __('ユーザー名'); ?></th>
            <th><?= __('コメント'); ?></th>
            <th><?= $this->Paginator->sort('modified', __('投稿時間')); ?></th>
            <th><?= __(""); ?></th>
        </tr>
        </thead>
        <?php foreach ($posts as $post): ?>
        <?php
        // 曜日を日本語で
        $w = date('w', strtotime($post['modified']));
        ?>
        <tr>
            <?php foreach($users as $targetUser): ?>
                <?php if($targetUser->id === $post->user_id): ?>
                    <td class="img-50">
                    <?php if($targetUser['photo']): ?>
                            <?= $this->Html->image('/files/Users/photo/'.$targetUser['photo'],['alt' => '写真を設定してください','class' => 'img-50']) ?>
                    <?php else: ?>
                            <?= $this->Html->image('noimage.png',['class' => 'img-50']) ?>
                    <?php endif ?>
                    </td>
                    <td><?= $targetUser->name ?></td>
                <?php endif ?>
            <?php endforeach ?>
            <td style="max-width: 400px;">
                <ul style="list-style: none; padding-left: 0px;">
                    <li class="urlComment"><?= nl2br($post->comment) ?></li>
                    <?php if($post->url !== ''): ?>
                      <li><a href="<?= $post->url?>" target="_blank"><?= $post->url ?></a></li>
                    <?php endif ?>
                </ul>
            </td>
            <td>
                <?= date('Y-m-d',strtotime($post->modified)); ?><?= $week[$w]; ?>
            </td>
            <td class="tc">
                <?php if($post->user_id === $user['id']): ?>
                    <?= $this->Html->link(__('修正'), ['action' =>'postEdit',$post->id]); ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'postDelete', $post->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $post->id)]) ?>
                <?php endif ?>

            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>
<?= $this->Html->script('url2link.js') ?>
