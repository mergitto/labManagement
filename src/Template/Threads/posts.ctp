<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link(__('スレッド一覧'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="posts form large-9 medium-8 columns content">
    <?= $this->Form->create($post) ?>
    <fieldset>
        <legend><?= __('新規コメント') ?></legend>
        <div class="form-group">
            <?= $this->Form->input('comment',['type'=>'text', 'label'=> 'コメント', 'class' => "form-control login-form"]); ?>
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
            <th><?= $this->Paginator->sort('comment', __('コメント')); ?></th>
            <th><?= $this->Paginator->sort('modified', __('投稿時間')); ?></th>
            <th><?= __(""); ?></th>
        </tr>
        </thead>
        <?php foreach ($thread->posts as $post): ?>
        <tr>
            <td>
                <?= $post->id; ?>
            </td>
            <td>
                <?= $post->comment; ?>
            </td>
            <td>
                <?= $post->modified; ?>
            </td>
            <td class="tc">
                <?php if($post->user_id === $user['id']): ?>
                  <?= $this->Html->link(__('編集'), ['action' =>'edit',$user['id']]); ?>
                <?php elseif($post->user_id === $user['id'] || $user['role'] === 'admin'): ?>
                    <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user['id']], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $post->id)]) ?>
                <?php endif ?>
              
            </td>
        </tr>
        <?php endforeach ?>
    </table>
</div>