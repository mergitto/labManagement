$(function(){
  if($('.select :checked').length ==  $('.select :input').length-1) {
    $('#allCheck').prop('checked', 'checked');
  }

  $('#allCheck').on('click', function() {
    $('.checkbox').prop('checked', this.checked);
  });

  $('.checkState').on('click', function(){
    if($('.select :checked').length ==  $('.select :input').length-1){ // -1は全選択のチェックボックスを数えないためである
      $('#allCheck').prop('checked', 'checked');
    } else {
      $('#allCheck').prop('checked', false);
    }
  });

  $('#atSerach').click(function(event){
    if($('.select :checked').length == 0) {
      alert('1つはタグを選択してください');
      event.preventDefault();
    }
  });
});
