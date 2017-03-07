<?php $this->assign('menu_title', __('管理者一覧')); ?>
<?php $this->assign('bodyId', 'fuPageEvaluateViewList'); ?>

<div class="fu-frame-main">
    <div class="container">
        <hr class="mb0">
        <?= $this->Session->flash(); ?>
        <?= $this->Form->create("User") ?>
        <div class="tools">
            <div class="row">
                <div class="col-xs-4">
                    <button type="button" class="btn btn-default">
                        <i class="glyphicon glyphicon-plus"></i>
                        <?= $this->Html->link(__('ユーザー新規作成'),['controller' => 'admins' ,'action' => 'add']) ?> 
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
                    <th><?= $this->Paginator->sort('admins_id', __('管理者ID')); ?></th>
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
                        <?= h($user['admins_id']); ?>
                    </td>
                    <td>
                        <?= h($user['password']); ?>
                    </td>
                    <td class="tc">
                        <?= $this->Html->link(__('編集'), ['action' =>'edit',$user['id']]); ?>
                        <?= $this->Html->link(__('削除'), ['action' =>'delete',$user['id']], ['title'=>'削除'], __('削除します。よろしいですか？')); ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
<!-- / .fu-frame-main -->