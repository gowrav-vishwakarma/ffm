<?php
if(ini_set('suhosin.post.max_name_length',256)===false) echo "You can't set";
echo "<pre>";
print_r(ini_get_all('suhosin'));
echo "</pre>";