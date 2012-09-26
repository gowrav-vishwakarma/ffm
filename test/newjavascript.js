/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(document).ready(function($) {
    $(".alertinwindow").each(function() {
        var $link = $(this);
        $link.click(function() {
            $($link).hide();
            var dialogDiv=$("<div></div>");
            var $dialog = $(dialogDiv)
            .load($link.attr("href")+"/" +Math.random(Date.now()))
            .dialog({
                autoOpen: false,
                title: $link.attr("title"),
                width: 600,
                modal: true
            });

            $dialog.dialog("open");

            return false;
        });
    });
});
