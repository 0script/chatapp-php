<?php

    // Unset all of the session variables.
    $_SESSION = array();
    session_destroy();
    $url='index.php?info=logoutOk';
    echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
?>