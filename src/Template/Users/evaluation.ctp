<?= $this->Html->script('Chart.js'); ?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2 class="mypage-title">マイページ</h2>
      <h3>
        <?php
          switch($todayHour) {
            case $todayHour >= 6 && $todayHour < 10:
              echo ('おはようございます'); break;
            case $todayHour >= 10 && $todayHour <= 18:
              echo ('こんにちは'); break;
            case ($todayHour > 18 && $todayHour <= 24) || $todayHour < 6 || $todayHour == 0:
              echo ('こんばんは'); break;
          } ?>
        <?= $user['nickname'].__('さん!') ?>
      </h3>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-5">
      <div class="row">
        <div class="col-xs-12">
          <h3><?= __($user['nickname'].'さんへの総いいね数') ?></h3>
        </div>
      </div>
      <div class="row flexiblebox">
        <div class="col-xs-5 text-right">
          <span class="font-70"><?= $iineEval['iine'] ?></span>
        </div>
        <div class="col-xs-2">
          <span class="font-70"><?= __("×") ?></span>
        </div>
        <div class="col-xs-5">
          <span class="font-100 favChecked"><i class="glyphicon glyphicon-thumbs-up ajaxFav mar-le-10"></i></span>
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-6">
      <div class="row flexiblebox">
        <blockquote class="sub-title"><?= __('評価') ?></blockquote>
        <div class="col-xs-3">
          <span class="average-font">平均</span>
        </div>
        <div class="col-xs-6">
          <span class="font-100" id="average"><?= $iineEval['evalAverage'] ?></span>
        </div>
        <div class="col-xs-3">
          <span class="score-font">点</span>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-sm-5">
        <tr class="img-350">
        <?php if($user['photo']): ?>
            <?= $this->Html->image('/files/Users/photo/'.$user['photo'],['alt' => '写真を設定してください', 'class' => 'cover']) ?>
        <?php else: ?>
            <?= $this->Html->image('noimage.png', ['class' => 'cover']) ?>
        <?php endif?>
        </tr>
        <p class="change-user-info"><?= $this->Html->link(__('ユーザー情報を変更する'), ['action' =>'edit',$user['id']]); ?></p>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-5">
      <canvas id='barChart'></canvas>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
<script type="text/javascript">
  //棒グラフ
  var ctx = document.getElementById('barChart');
  var labels = <?= json_encode($iineEval['scoreRange']) ?>;
  var averageScore = <?= json_encode(round($iineEval['evalAverage'])) ?> - 1; // 評価の平均点を四捨五入する
  var backColor = ['#d9534f', '#f0ad4e', '#337ab7', '#5bc0de', '#5cb85c'];
  $('#average').css('color', backColor[averageScore]); //平均点を四捨五入した点数と同じ点数の円グラフの色を文字色として設定する
  var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: Object.keys(labels),
      datasets: [{
      backgroundColor: backColor,
        data: Object.values(labels)
      }]
    },
    options: {
      title: {
        display: true,
        text: '発表評価点数の分布'
      },
      animation: {
        animateScale: true,
      }
    }
  });
</script>

