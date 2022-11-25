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
                <form action="" class="search">
                    <input class="field" type="text" placeholder="Search user..." />
                    <input class="submit" type="submit" value="Search" />
                </form>
                <form action="" class="post-form">
                    <textarea name="post" id="post" cols="50" rows="10" placeholder="Enter message"></textarea>
                    <div class="post-form-btn-container">
                        <button class="post-form-btn">Add Image</button>
                        <input class="post-form-btn" type="submit" value="Submit" />
                    </div>
                </form>
        </div>
    </div>

    <section class="container content">
            <div class="message-box">

                <h5>Username <span>timestamp<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
                <p>
                        amet cursus sit amet dictum sit amet justo donec enim diam vulputate 
                        ut pharetra sit amet aliquam id diam maecenas ultricies mi eget mauris 
                        pharetra et ultrices neque ornare aenean euismod elementum nisi quis 
                        eleifend quam adipiscing vitae proin sagittis nisl rhoncus mattis 
                        rhoncus urna neque viverra justo nec ultrices dui sapien eget mi proin 
                        sed libero enim sed faucibus turpis in eu mi bibendum neque egestas 
                        congue quisque egestas diam in arcu cursus euismod quis viverra nibh 
                        cras pulvinar mattis nunc sed blandit libero volutpat sed cras ornare 
                        arcu dui vivamus arcu felis bibendum ut tristique et egestas quis
                </p>
            </div>
            <div class="message-box">

                <h5>Username <span>timestamp<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
                <p>
                        amet cursus sit amet dictum sit amet justo donec enim diam vulputate 
                        ut pharetra sit amet aliquam id diam maecenas ultricies mi eget mauris 
                        pharetra et ultrices neque ornare aenean euismod elementum nisi quis 
                        eleifend quam adipiscing vitae proin sagittis nisl rhoncus mattis 
                        rhoncus urna neque viverra justo nec ultrices dui sapien eget mi proin 
                        sed libero enim sed faucibus turpis in eu mi bibendum neque egestas 
                        congue quisque egestas diam in arcu cursus euismod quis viverra nibh 
                        cras pulvinar mattis nunc sed blandit libero volutpat sed cras ornare 
                        arcu dui vivamus arcu felis bibendum ut tristique et egestas quis
                </p>
            </div>
            <div class="message-box">

                <h5>Username <span>timestamp<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
                <p>
                        amet cursus sit amet dictum sit amet justo donec enim diam vulputate 
                        ut pharetra sit amet aliquam id diam maecenas ultricies mi eget mauris 
                        pharetra et ultrices neque ornare aenean euismod elementum nisi quis 
                        eleifend quam adipiscing vitae proin sagittis nisl rhoncus mattis 
                        rhoncus urna neque viverra justo nec ultrices dui sapien eget mi proin 
                        sed libero enim sed faucibus turpis in eu mi bibendum neque egestas 
                        congue quisque egestas diam in arcu cursus euismod quis viverra nibh 
                        cras pulvinar mattis nunc sed blandit libero volutpat sed cras ornare 
                        arcu dui vivamus arcu felis bibendum ut tristique et egestas quis
                </p>
            </div>
    </section>

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
