$(function() {
    marked.setOptions({
        langPrefix: ''
    });

    // 文字が入力される度にmarkdown形式の表示を更新する
    $('#editor').keyup(function() {
        var src = $(this).val();
        var html = marked(src);
        $('#result').html(html);
        $('#result pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });

    // ページ読み込み時にmarkdown形式の表示に変更する
    $('.urlComment').each(function(){
      var src = $(this).text();
      var html = marked(src);
      $(this).html(html);
      $('pre code').each(function(i, block) {
          hljs.highlightBlock(block);
      });
    });


    // 編集画面の表示をmarkdown形式に変更する
    var src = $('#editor').val();
    var html = marked(src);
    $('#result').html(html);
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});

