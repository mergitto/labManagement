<?php $this->assign('menu_title', __('管理者一覧')); ?>
<?php $this->assign('bodyId', 'fuPageEvaluateViewList'); ?>

<div class="fu-frame-main">
    <div class="container">
        <hr class="mb0">
        <?= $this->Form->create("User") ?>
        <div class="tools">
            <div class="row">
                <div class="col-xs-4">
                    <button type="button" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i>
                        <?= $this->Html->link(__('ユーザー新規作成'),['controller' => 'admins' ,'action' => 'user_add']) ?> 
                    </button>
                </div>
                <div class="col-xs-8">
                </div>
            </div>
        </div>
        <?= $this->Form->end(); ?>

        <div class="fu-list">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', __('氏名')); ?></th>
                    <th><?= $this->Paginator->sort('role', __('ユーザーレベル')); ?></th>
                    <th><?= $this->Paginator->sort('password', __('パスワード')); ?></th>
                    <th class="b_w150">　</th>
                </tr>
                </thead>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?= h($user['name']); ?>
                    </td>
                    <td>
                        <?= h($user['role']); ?>
                    </td>
                    <td>
                        <?= h($user['password']); ?>
                    </td>
                    <td class="tc">
                        <?php if($loginUser['id'] === $user->id): ?>
                        <?= $this->Html->link(__('編集'), ['action' =>'edit',$user['id']]); ?>
                        <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $user->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $user->name)]) ?>
                        <?php endif ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
<!-- / .fu-frame-main -->
<div class="users index large-9 medium-8 columns content">
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('初め')) ?>
            <?= $this->Paginator->prev('< ' . __('前')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('{{page}}/{{pages}} ページ目,　{{count}}　人中 {{current}} 人表示')]) ?></p>
    </div>
</div>