<style>
  #calendar{
    width: 500px;
  }
</style>
<!-- カレンダー表示 -->
<div id="calendar"></div>
<!-- end カレンダー表示 -->

<div class="events small-12 medium-8 large-12 columns">
  <h2 class="inline-block"><?= __('ゼミ予定日');?></h2>
  <ul class="no-bullet inline-list inline-block">
    <li><?= $this->Html->link(__('予定追加', true), ['action' => 'add']); ?></li>
  </ul>
</div>
<div class="fu-frame-main">
    <div class="container">
        <hr class="mb0">

        <div class="fu-list">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title', __('ゼミタイトル')); ?></th>
                    <th><?= $this->Paginator->sort('status', __('状況')); ?></th>
                    <th><?= $this->Paginator->sort('start', __('ゼミ予定日')); ?></th>
                    <th></th>
                </tr>
                </thead>
                <?php foreach ($events as $event): ?>
                <tr>
                    <td>
                        <?= $event['title']; ?>
                    </td>
                    <td>
                        <?= $event['status']; ?>
                    </td>
                    <td>
                        <?= date(__('Y-m-d l'),strtotime($event->start)) ?>
                    </td>
                    <td class="tc">
                        <?= $this->Html->link(__('詳細'), ['action' => 'view', $event->id]); ?>
                        <?= $this->Html->link(__('編集'), ['action' =>'edit',$event['id']]); ?>
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
        <p><?= $this->Paginator->counter(['format' => __('{{page}}/{{pages}} ページ目,　{{count}}　件中 {{current}} 件表示')]) ?></p>
    </div>
</div>

<script>
$(function() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: false
      },
      weekends: false,
      editable: true,
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