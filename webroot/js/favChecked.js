$('.ajaxFav').click(function(){
  $.ajax({
      url: "/labManagement/favorites/favAjax",
      type: "POST",
      data: {
        user_id: $(this).attr('data-userId'),
        attachment_id: $(this).attr('data-attachmentId'),
        favorite_id: $(this).attr('data-favoId'),
        favStatus: $(this).parent().hasClass('favChecked')
      },
      context: this,
      dataType: "json",
  }).done(function(data,context){
    var $favCh = $(this).parent();
    if($favCh.hasClass('favChecked')){
      $favCh.removeClass('favChecked');
      $(this).removeData(['favoId']);
    }else{
      $favCh.addClass('favChecked');
      $(this).attr('data-favoId',data);
    }
  }).fail(function(){
    console.log("failed");
  });
});
