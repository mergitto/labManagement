<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?= $this->Html->link(__('ゼミ管理システム'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
    </div>
    <div class="collapse navbar-collapse text-center" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>
          <?= $this->Html->link(__('ゼミ予定一覧'), ['controller' => 'Events', 'action' => 'index']) ?>
        </li>
        <li>
          <?= $this->Html->link(__('掲示板'), ['controller' => 'Threads', 'action' => 'index']) ?>
        </li>
        <li>
          <?php if($user['role'] === 'admin'): ?>
            <?= $this->Html->link(__('行動計画(管理者用)'),['controller' => 'Admins', 'action' => 'activities', 0]) ?>
          <?php else: ?>
            <?= $this->Html->link(__('行動計画'),['controller' => 'Activities', 'action' => 'index']) ?>
          <?php endif ?>
        </li>
        <li>
          <?= $this->Html->link(__('ゼミ資料検索'),['controller' => 'Attachments', 'action' => 'view']) ?>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= __('ユーザー:') ?><?= $user['nickname'] ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><?= $this->Html->link(__('いいね資料'), ['controller' => 'Favorites', 'action' => 'view',$user['id']],['class' => 'text-center header-hover-style']) ?></li>
            <li><?= $this->Html->link(__('マイページ'), ['controller' => 'Users', 'action' => 'evaluation',$user['id']],['class' => 'text-center header-hover-style']) ?></li>
          </ul>
        </li>
        <li><?= $this->Form->postLink(__('ログアウト'),['action' => 'logout']) ?></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
