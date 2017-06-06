// urlをlinkに置換する
(function($) {
    $(".urlComment").each(function(){
        $(this).html( $(this).html().replace(/((http|https|ftp):\/\/[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1" target="_blank">$1</a> ') );
    });
})(jQuery);
