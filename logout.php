<?php

    session_start();
    session_unset();
    session_destroy();
    $_SESSION = array();
    $url='index.php?info=logoutOk';
    echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
?>