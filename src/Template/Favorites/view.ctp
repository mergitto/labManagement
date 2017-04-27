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
    <div class="fu-list">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th><?= __('ファイル名') ?></th>
            </tr>
            </thead>
            <?php foreach($favoriteFiles as $file): ?>
              <?php
              // 曜日を日本語で
              $w = date('w', strtotime($file['modified']));
              ?>
              <tr>
                  <td>
                      <?= $this->Html->link(__($file->attachment->file),['controller' => 'Attachments', 'action' => 'download',$file->attachment->file],['class' => 'font-20']) ?>
                      <i class="glyphicon glyphicon-download-alt" aria-hidden="true"></i>
                      <ul class="list-inline" style="list-style: none;">
                        <!--このページにアクセスした時-->
                        <?php foreach($attachments as $attachment): ?>
                          <?php if($file->user_id == $user['id'] && $file->attachment_id == $attachment->id): ?>
                            <?php foreach($attachment->tags as $tags): ?>
                              <li><span class="label label-success"><?= $tags['category'] ?></span></li>
                            <?php endforeach ?>
                          <?php endif ?>
                        <?php endforeach?>
                      </ul>
                  </td>
              </tr>
              <?php endforeach ?>
        </table>
    </div>
</div>
