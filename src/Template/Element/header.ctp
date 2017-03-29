<nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <?= $this->Html->link(__("ゼミ管理システム"), ['controller' => 'Users', 'action' => 'index'], ['class' => 'navbar-brand'] ) ?>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>
          <?= $this->Html->link(__('ゼミ予定一覧'), ['controller' => 'Events', 'action' => 'index']) ?>
        </li>
        <li>
          <?= $this->Html->link(__('掲示板'), ['controller' => 'Threads', 'action' => 'index']) ?>
        </li>
        <!--後々使うことになる可能性あるため残している
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
        -->
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="navbar-text"><?= __('ユーザー:') ?><?= $user['name'] ?></li>
        <li><?= $this->Form->postLink(__('ログアウト'),['action' => 'logout']) ?></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>