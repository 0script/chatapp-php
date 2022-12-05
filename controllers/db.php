<?php



    //active error reporting
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // connection to DB
    $conn=mysqli_connect("localhost","useranem","password","database") or die(mysqli_error($conn));
?>