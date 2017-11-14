// .taskModalをクリックしたらモーダルを表示
$('.taskModal').on('click', function(){
  $('#taskModal').modal('show');
  // チェックボックスにチェックがついていたら更新ボタンとチェックボックスを変更できないようにする
  if($('[name=modal-flag]').prop("checked")){
    $(".flg-update").prop("disabled", true);
    $("[name=modal-flag]").prop("disabled", true);
  }
});


// チェックボックスにチェックがつけられたら更新ボタンを表示させる
$('[name=modal-flag]').change(function(){
  if($(this).prop("checked")){
    $(".flg-update").show(300);
  } else {
    $(".flg-update").hide(300);
  }
});

// ajaxでUsersテーブルのtask_modal_flgを1にする
$('.flg-update').on('click', function(){
  if($('[name=modal-flag]').prop("checked")) { // checkboxにチェックがつけられていたらフラグを更新する
    $.ajax({
      url: "/labManagement/Users/taskModalFlag",
      type: "POST",
      data: {
        id: parseInt($('[name=modal-flag]:checked').val()),
        task_modal_flg: 1,
      },
      dataType: "json",
    }).done(function(data){
      $("#update-flg").css("display", "block");
      setTimeout(function(){
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('#taskModal').modal('hide');
      }, 1000)
    }).fail(function(){
      console.log("failed");
    });
  }
});
