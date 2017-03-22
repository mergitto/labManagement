<style>
  #calendar{
    width: 500px;
  }
</style>
<!-- カレンダー表示 -->
<div id="calendar"></div>
<!-- end カレンダー表示 -->

<div class="events small-12 medium-8 large-12 columns">
  <h2 class="inline-block"><?= __('Events');?></h2>
  <ul class="no-bullet inline-list inline-block">
    <li><?= $this->Html->link(__('予定追加', true), ['action' => 'add']); ?></li>
  </ul>
  <table cellpadding="0" cellspacing="0" class="small-12 columns">
    <tr>
        <th><?= $this->Paginator->sort('title');?></th>
        <th><?= $this->Paginator->sort('status');?></th>
        <th><?= $this->Paginator->sort('start');?></th>
        <th class="actions"></th>
    </tr>
    <?php
      $i = 0;
      foreach ($events as $event):
        $class = null;
        if ($i++ % 2 == 0) {
          $class = ' class="altrow"';
        }
    ?>
      <tr<?= $class;?>>
        <td><?= $event->title ?></td>
        <td><?= $event->status ?></td>
        <td><?= $event->start ?></td>
        <td class="actions">
          <?= $this->Html->link(__('View'), ['action' => 'view', $event->id]); ?>
          <?= $this->Html->link(__('Edit'), ['action' => 'edit', $event->id]); ?>
          <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $event->id], ['confirm' => 'Are you sure?']); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<div class="paginator small-12 small-centered medium-8 medium-centered large-6 large-centered columns text-center">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
<script>
$(function() {
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
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