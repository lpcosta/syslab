<?php
$getGet = filter_input_array(INPUT_GET,FILTER_DEFAULT);
$setGet = array_map("strip_tags", $getGet);
$get    = array_map("trim", $setGet);
extract($get);