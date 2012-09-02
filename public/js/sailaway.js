$(document).ready( function() {
    $(".messages").bind('click', function() {
        window.location = $(this).children('a').attr('href');
    });
});