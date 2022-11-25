<?php
    define('__ROOT__', dirname(dirname(__FILE__)));//define root dir
    require_once(__ROOT__.'/controllers/functions.php');//include functions.php file
?>

<?php
    
    $current_page=basename($_SERVER["PHP_SELF"]);//get current page name
    $pages_ = array("Home", "About", "Login","Logout");//a list for the navbar
    $navigations=array();

    //assignation of $navigations list
    foreach ($pages_ as $page_)  {
        if(strstr($current_page,strtolower($page_)) || (strstr($current_page,'index') && $page_=='Home'))
            array_push($navigations,'.<li class="current"><a style="color:#c0392b;" href="'.strtolower($page_).'.php">'.$page_.'</a></li>');
        else
            array_push($navigations,'.<li><a href="'.strtolower($page_).'.php">'.$page_.'</a></li>');
    }

    //using function to format array
    printf_array(
        '<nav class="nav">
            <div class="container">
                <h1 class="logo"><a href="index.html" >ChatApp</a></h1>                            
                <ul>
                    %s
                    %s
                    %s
                    %s
                </ul>
            </div>
        </nav>',
        $navigations

    );

?>
