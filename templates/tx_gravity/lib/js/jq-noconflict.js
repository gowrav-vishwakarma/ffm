//Call noconflict if detect jquery
//Apply jquery.noConflict if jquery is enabled
if ($defined(window.jQuery) && $type(jQuery.noConflict)=='function') {
    jQuery.noConflict();
}
