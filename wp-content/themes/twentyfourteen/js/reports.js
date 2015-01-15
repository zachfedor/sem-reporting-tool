/*
    Javascript functions for custom reports pages
 */

jQuery(document).ready(function($){
    $("div.rc-content").addClass("rc-hidden");

    $('.rc-title').on('click', function() {
        $(this).siblings('.rc-content').toggleClass("rc-hidden"); //you can list several class names
    });
});