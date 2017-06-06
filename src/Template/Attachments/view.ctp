<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="threads index large-9 medium-8 columns content container">
    <div class="row row-eq-height">
        <div class="col-xs-12">
            <h3><?= __('ゼミ資料検索') ?></h3>
            <hr class="md10">
        </div>
    </div>
    <div class="row">
      <div class="com-md-12">
        <?= $this->Form->create('Attachments',['url' => '/attachments/view', 'type' => 'post']); ?>
          <?= $this->Form->input('Tags._ids',[
            'option' => $tags,
            'multiple' => 'checkbox',
            'label' => 'タグ検索',
            'class' => 'checkbox checkState',
            'templates' => [
              'nestingLabel' => "<div class='col-xs-4'>{{hidden}}<label{{attrs}} >{{input}}{{text}}</label></div>",
            ]
          ]) ?>
          <div class="col-xs-4">
            <label for='allCheck'><input type='checkbox' id='allCheck'>全選択・解除</label>
          </div>
          <div class="col-md-2 pull-right">
            <?= $this->Form->button(__('検索'),['class' => 'glyphicon glyphicon-search btn btn-raised btn-success', 'id' => 'atSerach']) ?>
          </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>
    <hr class="md10">
    <div class="fu-list">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?=  __('ユーザー') ?></th>
                <th><?= __('タイトル') ?></th>
                <th><?= __('ファイル名') ?></th>
                <th><?= __('更新日') ?></th>
            </tr>
            </thead>
            <?php foreach($attachments as $attachment): ?>
              <?php
              // 曜日を日本語で
              $w = date('w', strtotime($attachment['modified']));
              ?>
              <tr>
                  <td>
                      <?= $attachment->user['name'] ?>
                  </td>
                  <td>
                      <?= $attachment['title']; ?>
                  </td>
                  <td>
                      <?= $this->Html->link(__($attachment->tmp_file_name),['controller' => 'Attachments', 'action' => 'download',$attachment->file]) ?>
                      <i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>
                      <ul class="list-inline" style="list-style: none;">
                        <!--このページにアクセスした時-->
                        <?php if(!is_null($attachment->tags)): ?>
                          <?php foreach($attachment->tags as $tag): ?>
                            <li><span class="label label-success"><?= $tag['category'] ?></span></li>
                          <?php endforeach?>
                        <?php endif ?>
                        <!--チェックボックスで選択した後-->

                        <?php if(!is_null($attachment->_matchingData['Tags'])): ?>
                          <?php $match = [];?><!--選択されたタグと一致する配列-->
                          <?php $miss = []; ?><!--選択されたタグと一致しない配列-->
                          <?php $tagHtml = []; ?><!--タグ用のHTML出力配列-->
                          <?php foreach($checkedTag as $checkedT): ?>

                            <?php if($attachment->id === $checkedT['id']): ?>
                              <?php foreach($allTag as $allT): ?>
                                <?php if($allT->file == $attachment->file): ?>
                                  <?php foreach($allT->tags as $at): ?>
                                    <!--ファイルが持つタグとチェックボックスにより選択されたタグが一致するかどうが-->
                                    <?php if(($at->category == $checkedT->_matchingData['Tags']['category'])): ?>
                                      <?php $match[$at->id] = $at->category ?>
                                    <?php else: ?>
                                      <?php $miss[$at->id] = $at->category ?>
                                    <?php endif ?>
                                  <?php endforeach?>
                                  <!--選択されていないタグのHTML出力-->
                                  <?php foreach($miss as $key => $missTag): ?>
                                    <?php $tagHtml[$key] = '<li><span class="label label-default">'.$missTag.'</span></li>' ?>
                                  <?php endforeach?>
                                  <!--選択されたタグでHTML出力上書き-->
                                  <?php foreach($match as $key => $matchTag): ?>
                                    <?php $tagHtml[$key] = '<li><span class="label label-success">'.$matchTag.'</span></li>' ?>
                                  <?php endforeach?>
                                <?php endif ?>
                              <?php endforeach ?>
                            <?php endif ?>
                          <?php endforeach ?>
                          <!--タグのHTML出力-->
                          <?php foreach($tagHtml as $value): ?>
                            <?= $value ?>
                          <?php endforeach ?>
                        <?php endif ?>
                      </ul>
                  </td>
                  <td>
                      <?= date('Y-m-d', strtotime($attachment['modified'])) ?><?= $week[$w]; ?>
                  </td>
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
<?php
$value = [];
foreach ($checkedList as $key => $checkId){
    $value[] = $checkId['id'];
}
?>
<script>
  var checkTag = <?php echo json_encode($value); ?>;
  //console.log(checkTag);
  $(function(){
    $('.checkbox').val(checkTag);
  });
</script>
<?= $this->Html->script('tagSelect.js') ?>
