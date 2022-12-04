<?php

    // session start
    session_start();    
    //define('__ROOT__', dirname(dirname(__FILE__)));//define root dir
    
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
                    <form class="login-form" method="post">
                        <h2>Register</h2>
                        <input name="username" id="username" class="username-input" type="text" placeholder="Enter Username"/>
                        <p class="error" id="username-error"></p>
                        <input name="email" id="email" class="username-input" type="email" placeholder="Enter Email"/>
                        <p class="error" id="email-error"></p>
                        <input name="password" id="password" class="username-input" type="password" placeholder="Enter Password"/>
                        <div class="login-form-btn-container">
                            <button class="login-form-btn" id="login"><a href="login.php">Login</a></button>
                            <button class="login-form-btn" id="register">Rergister</button>
                        </div>
                    </form>
                    </p>
            </div>
            <div class="notification-container">
                <div class="notification"></div>
            </div>
        </div>
        <div id="php-error"></div>
        <script>
            const nav=document.querySelector('.nav');
            const register_btn=document.querySelector('button#register');

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

            function validateEmail(email){

                const emailRegex=/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                if(email.match(emailRegex))
                    return true;
                else
                    document.getElementById('email-error').innerHTML='Email is not valid !';
                return false;
            }

            function registerform(){
                
                let username=document.getElementById('username').value.trim();
                let email=document.getElementById('email').value.trim();
                let password=document.getElementById('password').value.trim();
                
                if(validateUsername(username) && validateEmail(email)){

                    let obj=`username=${username}&email=${email}&password=${password}`;
                    let url_success=window.location.protocol+'//'+window.location.hostname+'/index.php?info=registrationOK';
                    let xmlhttp=new XMLHttpRequest();

					console.log('sending post request');
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {

                            const obj=JSON.parse(this.responseText);
                            console.log('response text : '+this.responseText)
                            console.log('response json : '+(this.responseText));
                            
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

					xmlhttp.open("POST","controllers/register.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(obj);
                }else{
                    console.log('not true');
                }
            }
            
            register_btn.addEventListener('click',(e)=>{
                e.preventDefault();
                registerform();
            });

        </script>
    </body>
</html>