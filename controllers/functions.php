<?php
    function printf_array($format, $arr){ 
        return call_user_func_array('printf', array_merge((array)$format, $arr)); 
    } 
?>