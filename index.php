<?php

    // session start
    session_start();
    
    //define session variable
    if(!isset($_SESSION['user']) && !isset($_SESSION['start_time'])){
        $_SESSION['user']='unknow';
        $_SESSION['start_time']=time();
        $_SESSION['chat']='groupchat';
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

                <form action="search-results.php" method="get" class="search">
                    <input class="field" type="text" name="q" id="q" placeholder="Search user..." />
                    <input class="submit" type="submit" value="Search" />
                </form>
                <form method="post" class="post-form">
                    <textarea name="post" id="post" cols="47" rows="9" placeholder="Enter message"></textarea>
                    <input type="text" name="sendto" id="sendto" class="sendto" placeholder="Enter Receiver Username" />
                    <div class="post-form-btn-container">
                        <input id="post-form-btn" class="post-form-btn" type="submit" value="Send ." />
                    </div>
                </form>
                <div class="presentation-text">
                    <h4 class="title">
                        <?php
                            
                            if(isset($_SESSION['user'])){
                                if($_SESSION['user']!='unknow'){
                                    echo '<span>'.$_SESSION['user'].'</span> ';
                                }
                            }
                            
                            if(isset($_GET['info'])){
                                if($_GET['info']=='loginOK'){
                                    echo "login successful";
                                }else if($_GET['info']=='registrationOK'){
                                    echo "registration successful";
                                }else if($_GET['info']=='logoutOK'){
                                    echo "logout was OK";
                                }else if($_GET['info']='sendedOK'){
                                    echo "The message sent successful";
                                }else if($_GET['info']='sendedError'){
                                    echo "Error unable to send the message";
                                }
                            }else{
                                echo " Welcome to the chat";
                            }
                        ?>
                    </h4> 
                </div>
        </div>
        <div class="notification-container">
            <div class="notification"></div>
        </div>
    </div>

    <div class="main-btn-container" id="main-btn-container">
        <button class="groupchat-btn">GROUPCHAT <i class="fa-solid fa-user-group"></i></button>
        <button class="sended-btn">SENDED <i class="fa-solid fa-paper-plane"></i></button>
        <button class="received-btn">INBOXES <i class="fa-solid fa-inbox"></i></button>
    </div>

    <section class="container content">

    </section>

    <script>
        const nav=document.querySelector('.nav');
        const section=document.querySelector('section.container');

        window.addEventListener('scroll',fixNav);

        function fixNav(){
            if(window.scrollY>nav.offsetHeight+150){
                nav.classList.add('active');
            }else{
                nav.classList.remove('active');
            }
        }


        function display_message(msgs){

            section.innerHTML='';
            msgs.reverse().forEach(msg => {
                section.innerHTML+=`
                    <div    class="message-box">
                        <h5>${msg.username} <span>${msg.created_date}</span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i></h5> 
                        <p>${msg.message}</p>
                    </div>                    
                `;

            });
        }

        function getmessagerequest(chatname){
            
            let xmlhttp=new XMLHttpRequest();
            let obj=`chatname=${chatname}`;

            xmlhttp.onreadystatechange=function(){
                if(this.readyState==4 && this.status==200){

                    //console.log(this.responseText);
                    const data=JSON.parse(this.responseText);
                    console.log(data.type);
                    console.log(data.data);

                    if(data.type=='success'){
                        display_message(data.data);
                    }else{
                        section.innerHTML=`
                                    <div class="message-box">

                                        <h5>No message <span>timestamp<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
                                        <p>
                                            WOW SUCH AN EMPTY  PLACE !!!
                                        </p>
                                    </div> 
  
                        `;

                    }

                }
            }

            xmlhttp.open("POST","controllers/functions.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send(obj);
        }

        document.querySelector('button.groupchat-btn').addEventListener('click',()=>{

            console.log('groupchat');
            getmessagerequest('groupchat');

        });

        document.querySelector('button.sended-btn').addEventListener('click',()=>{

            console.log('sendedmsg');
            getmessagerequest('sendedmsg');

        });
        
        document.querySelector('button.received-btn').addEventListener('click',()=>{

            console.log('inboxes');
            getmessagerequest('inboxesmsg');

        });

        //display groupchat by default
        getmessagerequest('groupchat');


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

        function sendmessage(){
                
                let receiver=document.getElementById('sendto').value.trim();
                let message=document.getElementById('post').value.trim();
                console.log(receiver);

                if(message!=''){

                    let obj=`message=${message}&receiver=${receiver}`;
                    let url_success=window.location.protocol+'//'+window.location.hostname+'/index.php?info=sendendOK';
                    let url_error=window.location.protocol+'//'+window.location.hostname+'/index.php?info=sendedError';
                    let xmlhttp=new XMLHttpRequest();

					console.log('sending post request');
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {

                            const obj=JSON.parse(this.responseText);
                            // console.log('response text : '+this.responseText);
                            // console.log('response json : '+(this.responseText));
                            
                            console.log(this.responseText);

                            createNotification(obj.message,obj.type);

                            if(obj.type=='success'){
                                //redirect to the home page
                                setTimeout(() => {
                                    console.log(url_success);
                                    window.location.href=url_success;
                                }, 1999);
                            }else{

                                setTimeout(() => {
                                    console.log(url_error);
                                    window.location.href=url_error;
                                }, 1999);
                            }
						}
					};

					xmlhttp.open("POST","controllers/send.php", true);
					xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xmlhttp.send(obj);
                }else{
                    console.log('not true');
                }
        }

        document.querySelector('input#post-form-btn').addEventListener('click',(e)=>{
            e.preventDefault();
            sendmessage();
        });

        

    </script>
</body>
</html>
