$('.loading').on('click', function(){
  if($('.comment-area').val() != ''){
    $('#loader-bg').css('display', 'block');
    $('#loader').css('display', 'block');
  }
});
