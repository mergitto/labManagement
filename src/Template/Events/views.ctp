<div class="fu-frame-main">
  <div class="container">
    <h3><?= __("全ゼミ一覧") ?><span class="font-16"><?= $this->Html->link(__('(ゼミ一覧へ)'), ['action' => 'index']); ?></span></h3>
    <hr class="mb0">
    <div class="fu-list">
      <table class="table table-hover table-striped">
        <thead>
        <tr>
          <th class="col-md-3"><?= $this->Paginator->sort('title', __('ゼミタイトル')); ?></th>
          <th class="col-md-4"><?= __('登録されている資料'); ?></th>
          <th class="col-md-2 hidden-xs"><?= __('ゼミ担当者'); ?></th>
          <th class="col-md-2"><?= $this->Paginator->sort('start', __('ゼミ日')); ?></th>
          <th class="col-md-1 b_w150">　</th>
        </tr>
        </thead>
        <?php foreach ($events as $event): ?>
          <tr>
            <td>
              <?= $this->Html->link(__($event['title']), ['action' => 'view', $event->id],['class' => 'font-20']); ?>
            </td>
            <td>
              <?php foreach($event['attachments'] as $attachment): ?>
                <p><?= $this->Html->link(__($attachment['tmp_file_name']), ['controller' => 'Attachments' ,'action' => 'download', $attachment['file']],['class' => 'font-16']); ?></p>
              <?php endforeach ?>
            </td>
            <td class="hidden-xs">
              <?php foreach($event['users'] as $asignUser): ?>
                <?= $asignUser['name'] ?>
              <?php endforeach ?>
            </td>
            <td>
              <?= $event['start']->i18nFormat('YYYY-MM-dd'); ?>
              <?= $week[date('w', strtotime($event['start']))]; ?>
            </td>
            <td class="tc">
              <?php if($user['role'] == 'admin'): ?>
                <?= $this->Html->link(__('編集'), ['action' =>'edit',$event['id']]); ?>
                <?= $this->Form->postLink(__('削除'), ['action' => 'delete', $event->id], ['confirm' => __('本当に削除してよろしいですか　# {0}?', $event['id'])]) ?>
              <?php endif ?>
            </td>
          </tr>
        <?php endforeach ?>
      </table>
    </div>
  </div>
</div>
<div class="events index large-9 medium-8 columns content">
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
