/*
    Javascript functions for custom reports pages
 */

jQuery(document).ready(function($){
    $("div.rc-content").addClass("rc-hidden");

    $('.rc-title').on('click', function() {
        $(this).siblings('.rc-content').toggleClass("rc-hidden");
        $(this).toggleClass("rc-title-open");
    });
});