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
            <?= $this->Form->textarea('comment',['type'=>'text', 'label'=> 'コメント', 'class' => "form-control login-form"]); ?>
            <?= $this->Form->input('user_id', ['type' => 
            'hidden' ,'value' => $user['id'], 'label' => 'タイトル名']); ?>
            <?= $this->Form->input('thread_id', ['type' => 
            'hidden' ,'value' => $thread->id, 'label' => 'タイトル名']); ?>
        </div>
    </fieldset>
    <div class="login-button text-right">
    <?= $this->Form->button(__('新規登録'),['class' => 'btn btn-raised btn-success']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
<div class="fu-list">
    <table class="table table-hover">
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('id', __('ID')); ?></th>
            <th><?= $this->Paginator->sort('name', __('ユーザー名')); ?></th>
            <th><?= $this->Paginator->sort('comment', __('コメント')); ?></th>
            <th><?= $this->Paginator->sort('modified', __('投稿時間')); ?></th>
            <th><?= __(""); ?></th>
        </tr>
        </thead>
        <?php foreach ($posts as $post): ?>
        <tr>
            <td>
                <?= $post->id; ?>
            </td>
            <?php foreach($users as $targetUser): ?>
                <?php if($targetUser->id === $post->user_id): ?>
                    <?php if($targetUser['photo']): ?>
                        <td>
                            <?= $this->Html->image('/files/Users/photo/'.$targetUser['photo'],['alt' => '写真を設定してください','class' => 'img-100']) ?>
                        </td>
                    <?php else: ?>
                        <td>
                            <?= $this->Html->image('pika.jpg',['class' => 'img-100']) ?>
                        </td>
                    <?php endif ?>
                    <td><?= $targetUser->name ?></td>
                <?php endif ?>
            <?php endforeach ?>
            <td style="max-width: 400px;">
                <?= nl2br($post->comment) ?>
            </td>
            <td>
                <?= date('Y-m-d H:i',strtotime($post->modified)); ?>
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