<div class="fu-frame-main">
  <div class="container">
    <h3><?= __('ゼミ予定日');?></h3>
    <hr class="mb0">
    <div class="row">
      <div class="col-md-7">
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
          <table class="table table-hover">
              <thead>
              <tr>
                  <th><?= __('ゼミタイトル'); ?></th>
                  <th><?= __('ゼミ予定日'); ?></th>
                  <th></th>
              </tr>
              </thead>
              <?php foreach ($events as $event): ?>
                <?php
                // 曜日を日本語で
                $w = date('w', strtotime($event->start));
                ?>
              <tr>
                  <td>
                      <?= $this->Html->link(__($event['title'].'('.count($event->attachments).')'), ['action' => 'view', $event->id]); ?>
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
              <?php
                //その日のゼミにファイルを登録しているかをチェックする
                $checkUsers = [];
                foreach ($event->attachments as $at) {
                  if(!is_null($at->file)){
                    $checkUsers[] = $at->user_id;
                  }
                }
              ?>
              <tr>
                 <td style="border-top:none; max-width:150px;">
                   <?php foreach ($event->users as $eventUser): ?>
                     <?php if(array_search($eventUser->id, $checkUsers) === FALSE): ?>
                      <span class="text-muted"><?= $eventUser['name']; ?></span>
                     <?php else: ?>
                      <span class="text-primary font-b"><?= $eventUser['name']; ?></span>
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
