$(function() {
    marked.setOptions({
        langPrefix: ''
    });

    // 文字が入力される度にmarkdown形式の表示を更新する
    $('#editor').keyup(function() {
        var src = $(this).val();

        var html = marked(src);

        $('#result').html(html);

        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
        // ここで[x]を選択済みのチェックボックスに[ ]を未選択のチェックボックスに変換
        html = html.replace(/\[x\]/gi, '<input type="checkbox" checked="checked">');
        html = html.replace(/\[ \]/gi, '<input type="checkbox" >');
    });

    // ページ読み込み時にmarkdown形式の表示に変更する
    $('.urlComment').each(function(){
      var comment = $(this).text();

      var html = marked(comment);

      $(this).html(html);

      $('pre code').each(function(i, block) {
          hljs.highlightBlock(block);
      });
      // ここで[x]を選択済みのチェックボックスに[ ]を未選択のチェックボックスに変換
      html = html.replace(/\[x\]/gi, '<input type="checkbox" checked="checked">');
      html = html.replace(/\[ \]/gi, '<input type="checkbox" >');
    });


    // 編集画面の表示をmarkdown形式に変更する
    var src = $('#editor').val();
    var html = marked(src);
    $('#result').html(html);
    $('pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
    // ここで[x]を選択済みのチェックボックスに[ ]を未選択のチェックボックスに変換
    html = html.replace(/\[x\]/gi, '<input type="checkbox" checked="checked">');
    html = html.replace(/\[ \]/gi, '<input type="checkbox" >');
});

