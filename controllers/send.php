<?php

    // session start
    session_start();
    // include DB connection
    include('./db.php');

    // declaring variables
    $message='';
    $sender='';
    $receiver='';
    $sended_by_id='';
    $sended_to_id='';
    $response_=[];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        $message=$_POST['message'];
        $receiver=$_POST['receiver'];
        $sender=$_SESSION['user'];

        if($_SESSION['user']=='unknow'){

            $response_['message']='Login to send message !!';
            $response_['type']='error';            
        }else{
            //user exist send message
            if(isset($_POST['message'])){

                //check destination
                if($_POST['receiver']==''){
                    //send into group
                    // $sended_by=$conn->query("SELECT `user_id` FROM `users` WHERE username = ".$_SESSION['user']);      
                    // $sql_query="SELECT `user_id` FROM `users` WHERE username= `$sender`";
                    // $sended_by=$conn->query("SELECT `user_id` FROM `users` WHERE username= $sender");

                    $statement=$conn->prepare("SELECT `user_id` FROM `users` WHERE`username`=?");
                    $statement->bind_param("s",$sender);
                    $statement->execute();

                    // $result=$statement->get_result();
                    // $row=$result->fetch_assoc();
                    
                    $sended_by=$statement->get_result();
                    $row=$sended_by->fetch_assoc();

                    if($row!=null){
                        //valid username
                        $sended_by_id=$row['user_id'];

                        //insert the message into the database 
                        $statement=$conn->prepare("INSERT INTO `groupchatmsg` (`send_by`,`username`,`message`) VALUE (?,?,?)");
                        $statement->bind_param('iss',$sended_by_id,$sender,$message);
                        
                        if($statement->execute()){
                            //proced query was succeffful
                            $response_['message']= 'Message was sent !!';
                            $response_['type']='success';
                        }else{
                            //error yet again
                            $response_['message']= 'Error doing statement '.$statement.' with : '.$conn->error;
                            $response_['type']='error';
                        }
                        

                    }else{
                        $response_['message']= 'Error doing sql query query object '.$sended_by.' with : '.$conn->error;
                        $response_['type']='error';
                    }

                    // if($sended_by){
                    //     if($sended_by->num_rows>0){
                    //         $row=mysql_fetch_assoc($sended_by);
                    //         $sended_by_id=$row['id'];

                    //         $response_['message']= 'Success about to send ';
                    //         $response_['type']='error';
                            
                    //     }else{
                    //         $response_['message']= 'Error doing sql query'.$sql_query.' query object '.$sended_by.' with : '.$conn->error;
                    //         $response_['type']='error';
                    //     }
                    // }else{
                    //     $response_['message']= 'Error doing sql query'.$sql_query.' query object '.$sended_by.'and sender'.' with : '.$conn->error;
                    //     $response_['type']='error';
                    // }

                }
            }else{
                $response_['message']='Error can not send empty message!!';
                $response_['type']='error';
            }
        }
    }else{
        $response_['message']='Registration Failed , fill the form properly!!';
        $response_['type']='success';
    }

    echo json_encode($response_);
?>
