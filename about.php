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
                    <h3>Welcome the chat application</h3>
                    <p>A simple chat to get in contact with your relative</p>
            </div>
            <div class="notification-container">
                <div class="notification"></div>
            </div>
        </div>

        <script>
            const nav=document.querySelector('.nav');
            const login_btn=document.querySelector('button#login');
            
            window.addEventListener('scroll',fixNav);

            function fixNav(){
                if(window.scrollY>nav.offsetHeight+150){
                    nav.classList.add('active');
                }else{
                    nav.classList.remove('active');
                }
            }

            function createNotification(message_=null,type_=null){
                /* create notification message */
                const notification=document.createElement('div');

                notification.classList.add('notification');
                notification.classList.add(type_?type_:'info');
                notification.innerHTML=message_;

                document.querySelector('div.notification-container').appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);

            }

            function validateUsername(username){

                if(username.length<5){
                    document.getElementById('username-error').innerHTML='Username should be at least 5 characters!';
                    return false;
                }
                return true;
            }

            function registerform(){
                
                let username=document.getElementById('username').value.trim();
                let password=document.getElementById('password').value.trim();
                
                if(validateUsername(username)){

                    let obj=`username=${username}&password=${password}`;
                    let url_success=window.location.protocol+'//'+window.location.hostname+'/index.php?info=loginOK';
                    let xmlhttp=new XMLHttpRequest();

					console.log('sending post request');
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {

                            const obj=JSON.parse(this.responseText);
                            // console.log('response text : '+this.responseText)
                            // console.log('response json : '+(this.responseText));
                            
                            createNotification(obj.message,obj.type);
                            if(obj.type=='success'){
                                //redirect to the home page
                                setTimeout(() => {
                                    console.log(url_success);
                                    window.location.href=url_success;
                                }, 2999);
                            }
						}
					};

					xmlhttp.open("POST","controllers/login.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(obj);
                }else{
                    console.log('not true');
                }
            }
            
            login.addEventListener('click',(e)=>{
                e.preventDefault();
                registerform();
            });

        </script>
    </body>
</html>