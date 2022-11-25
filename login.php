<?php

    // session start
    session_start();
    
    //define session variable
    if(!isset($_SESSION['user']) && !isset($_SESSION['start_time'])){
        $_SESSION['user']='unknow';
        $_SESSION['start_time']=time();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ULK CHAT</title>
        <!-- external stylesheets -->
        <link rel="stylesheet" href="publics/css/css.css">
        <!-- Favicon  : this bellong to me  register  on fontawesome and use yours -->
        <script src="https://kit.fontawesome.com/e6fe1098a1.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!--NAVIGATION BAR-->
        <?php include 'views/nav.php'; ?>

        <div class="hero">
            <div class="container form-container">
                    <form action="" class="login-form">
                        <h2>Login</h2>
                        <input name="username" id="username" class="username-input" type="text" placeholder="Enter Username"/>
                        <input name="password" id="password" class="username-input" type="password" placeholder="Enter Password"/>
                        <div class="login-form-btn-container">
                            <button class="login-form-btn" id="login">Login</button>
                            <button class="login-form-btn" id="register"><a href="register.php">Rergister</a></button>
                        </div>
                    </form>
            </div>
        </div>

        <script>
            const nav=document.querySelector('.nav');

            window.addEventListener('scroll',fixNav);

            function fixNav(){
                if(window.scrollY>nav.offsetHeight+150){
                    nav.classList.add('active');
                }else{
                    nav.classList.remove('active');
                }
            }

        </script>
    </body>
</html>