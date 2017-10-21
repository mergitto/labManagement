<div class="activities content container">
  <div class="row text-center">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <span class="font-24"><?= $user['nickname'].__('さんの研究テーマ') ?></span>
          <span class="retheme"><?= $this->Html->link(__('研究テーマの修正'), ['action' => 'edit',$result['id']]); ?></span>
          </div>
        <div class="panel-body">
          <h3 class="theme"><strong><?= $result['theme']; ?></strong></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('本日のタスク') ?></h2>
          <hr>
          <h3><strong><?= __('〇〇の試みと応用') ?></strong></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('ToDo') ?></h2>
          <?= $this->Html->link(__('ToDoの登録'), ['controller' => 'Plans', 'action' => 'add']); ?>
          <hr>
          <ul>
            <?php foreach($plans as $plan): ?>
              <li><span class="font-20"><?= $plan['todo'] ?></span><?= $this->Html->link(__('ToDoの修正'), ['controller' => 'Plans','action' => 'edit',$plan['id']]); ?></li>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('タスク') ?></h2>
          <hr>
          <ul>
            <li><h3><?= __('〇〇の試みと応用') ?></h3></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('サブタスク') ?></h2>
          <hr>
          <ul>
            <li><h3><?= __('〇〇の試みと応用') ?></h3></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('解決済みのタスク') ?></h2>
          <hr>
          <h3><strong><?= __('〇〇の試みと応用') ?></strong></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h2><?= __('みんなの進捗度') ?></h2>
          <hr>
          <h3><strong><?= __('〇〇の試みと応用') ?></strong></h3>
        </div>
    </div>
  </div>
</div>
