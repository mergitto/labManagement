$(function() {
    marked.setOptions({
        langPrefix: ''
    });

    $('#editor').keyup(function() {
        var src = $(this).val();

        var html = marked(src);

        $('#result').html(html);

        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });

    var src = $('#editor').val();
    var html = marked(src);
    $('#result').html(html);

    $('.urlComment').each(function(){
      var comment = $(this).text();
      var comment2html = marked(comment);
      $(this).html(comment2html);
    });
});

