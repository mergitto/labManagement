<?php $this->assign('menu_title', __('管理者一覧')); ?>
<?php $this->assign('bodyId', 'fuPageEvaluateViewList'); ?>
<div class="fu-frame-main">
    <div class="container">
        <h3><?= __("ユーザー情報") ?></h3>
        <hr class="mb0">
        <?= $this->Form->create("User") ?>
        <div class="tools">
            <div class="row">
                <div class="col-xs-4">
                  <?= $this->Html->link(__('ユーザー新規作成'),['controller' => 'admins' ,'action' => 'user_add'], ['class' => 'btn btn-default']) ?>
                </div>
                <div class="col-xs-8">
                </div>
            </div>
        </div>
        <?= $this->Form->end(); ?>

        <div class="fu-list">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th colspan="2"><?= __('ユーザー名'); ?></th>
                    <th><?= __('E-mail'); ?></th>
                    <th><?= __('電話番号'); ?></th>
                    <th class="b_w150">　</th>
                </tr>
                </thead>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td class="img-50">
                    <?php if($user['photo']): ?>
                        <?= $this->Html->image('/files/Users/photo/'.$user['photo'],['alt' => '写真を設定してください','class' => 'img-50']) ?>
                    <?php else: ?>
                        <?= $this->Html->image('noimage.png',['class' => 'img-50']) ?>
                    <?php endif?>
                    </td>
                    <td>
                        <p><?= $user['name']; ?></p>
                        <p><?= __("表示名:").$user['nickname']; ?></p>
                    </td>
                    <td>
                        <span class="glyphicon glyphicon-envelope"></span>
                        <?= $user['email']; ?>
                    </td>
                    <td>
                        <span class="glyphicon glyphicon-phone"></span>
                        <?= $user['phone']; ?>
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
