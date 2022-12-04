<?php

    //active error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // connection to DB
    $conn=mysqli_connect("localhost","phpmyadmin","Admin@Php#1234","chatappdb") or die(mysqli_error($conn));
?>