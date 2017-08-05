<?php $rCount = 1;?>
<?php foreach($threeTag as $key => $rankTag): ?>
  <div class="col-md-4 ranking-list">
    <div class="row">
      <div class="col-xs-6">
        <div class="rank-<?= $rankTag['rank']; ?>"></div>
      </div>
      <div class="col-xs-6">
        <div class="w-100">
          <span class="label label-default label-color-<?= $rankTag['rank']; ?>"><?= $key ?></span>
        </div>
        <div class="w-100">
          <i class="glyphicon glyphicon-thumbs-up mar-le-10 gly-color-<?= $rankTag['rank']; ?>"></i><?= __(':').$rankTag['count'] ?>
        </div>
      </div>
    </div>
  </div>
<?php $rCount++; ?>
<?php endforeach ?>
