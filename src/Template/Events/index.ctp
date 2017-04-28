<div class="fu-frame-main">
  <div class="container">
    <h3><?= __('ゼミ予定日');?></h3>
    <hr class="mb0">
    <div class="row">
      <div class="col-md-7">
        <div class="row">
          <?php $rCount = 1;?>
          <?php foreach($rankTags as $key => $rankTag): ?>
            <div class="col-md-4 ranking-list">
              <div class="row">
                <div class="col-xs-6">
                  <div class="rank-<?= $rCount; ?>"></div>
                </div>
                <div class="col-xs-6">
                  <div class="w-100">
                    <span class="label label-default label-color-<?= $rCount; ?>"><?= $key ?></span>
                  </div>
                  <div class="w-100">
                    <i class="glyphicon glyphicon-thumbs-up mar-le-10 gly-color-<?= $rCount; ?>"></i><?= __(':').$rankTag ?>
                  </div>
                </div>
              </div>
            </div>
          <?php $rCount++; ?>
          <?php endforeach ?>
        </div>
        <!-- カレンダー表示 -->
        <div id="calendar"></div>
        <!-- end カレンダー表示 -->
      </div>
      <div class="col-md-5">
        <div class="events small-12 medium-8 large-12 columns">
          <button type="button" class="btn btn-default">
              <i class="glyphicon glyphicon-calendar" aria-hidden="true"></i>
              <?= $this->Html->link(__('予定追加'), ['action' => 'add']); ?>
          </button>
        </div>
        <div class="fu-list">
          <table class="table">
              <thead>
              <tr>
                  <th><?= __('ゼミタイトル・担当'); ?></th>
                  <th class="min-w-120"><?= __('ゼミ予定日'); ?></th>
                  <?php if($user['role'] === 'admin'): ?>
                  <th class="min-w-50"></th>
                  <?php endif ?>
              </tr>
              </thead>
              <?php foreach ($events as $key => $event): ?>
                <?php
                // 曜日を日本語で
                $w = date('w', strtotime($event->start));
                ?>
              <?php if($key % 2 === 0): ?>
                <tr class="active">
              <?php else: ?>
                <tr>
              <?php endif ?>
                  <td>
                      <?= $this->Html->link(__($event['title']), ['action' => 'view', $event->id],['class' => 'font-24']); ?>
                      <?= '('.count($event->attachments).')' ?>

                      <div class="progress progress-striped active">
                        <?php if(isset($submittedUsers[$event->id])): ?>
                          <div class="progress-bar progress-bar-success" style="width: <?= (int)count($submittedUsers[$event->id]) / (int)$countUsers[$event->id] * 100; ?>%"></div>
                        <?php else: ?>
                          <div class="progress-bar" style="width: 0%"></div>
                        <?php endif ?>
                      </div>
                  </td>
                  <td rowspan="2" style="vertical-align:middle;">
                      <?= date(__('Y-m-d'),strtotime($event->start)) ?><?=$week[$w]?>
                  </td>
                  <?php if($user['role'] === 'admin'): ?>
                  <td class="tc">
                        <?= $this->Html->link(__('編集'), ['action' =>'edit',$event['id']]); ?>
                  </td>
                  <?php endif ?>
              </tr>
              <?php if($key % 2 === 0): ?>
                <tr class="active">
              <?php else: ?>
                <tr>
              <?php endif ?>
                 <td style="border-top:none; max-width:150px;">
                   <?php foreach ($event->users as $eventUser): ?>
                     <?php if(array_key_exists($event->id, $checkUsers)): ?>
                       <?php if(array_search($eventUser->id, $checkUsers[$event->id]) === FALSE): ?>
                        <span class="text-muted"><?= $eventUser['name']; ?></span>
                       <?php else: ?>
                        <span class="text-default font-b"><?= $eventUser['name']; ?></span>
                       <?php endif ?>
                     <?php else: ?>
                       <span class="text-muted"><?= $eventUser['name']; ?></span>
                     <?php endif ?>
                   <?php endforeach ?>
                 </td>
                 <?php if($user['role'] === 'admin'): ?>
                 <td>
                   <?= $this->Form->postLink(__('削除'), ['action' =>'delete',$event->id], ['confirm' => __('本当に削除してもいいですか # {0}?' , $event['title'])]); ?>
               </td>
               <?php endif ?>
              </tr>
              <?php endforeach ?>
          </table>
        </div>
        <div class="users index large-9 medium-8 columns content">
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
      </div>
    </div>
  </div>
</div>
<!-- / .fu-frame-main -->
<script>
$(function() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: false
      },
      weekends: false,
      editable: false,
      locale: 'ja',
      events: <?= htmlspecialchars_decode($json, ENT_QUOTES )?>
    })
});
</script>
<?= $this->Html->css('fullcalendar.css'); ?>
<?= $this->Html->css('jquery.qtip.min.css'); ?>
<?= $this->Html->script('moment.min.js'); ?>
<?= $this->Html->script('fullcalendar.js'); ?>
<?= $this->Html->script('ja.js'); ?>
<?= $this->Html->script('jquery.qtip.min.js'); ?>
<?= $this->Html->script('ready.js'); ?>
