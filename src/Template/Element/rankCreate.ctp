<?php $rCount = 1;?>
<?php foreach($allTags as $key => $rankTag): ?>
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
