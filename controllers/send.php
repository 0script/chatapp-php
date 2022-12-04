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


                $statement=$conn->prepare("SELECT `user_id` FROM `users` WHERE`username`=?");
                $statement->bind_param("s",$sender);
                $statement->execute();
                    
                $sended_by=$statement->get_result();
                $row=$sended_by->fetch_assoc();

                if($row!=null){
                    //valid username
                    $sended_by_id=$row['user_id'];

                    //check if there is a receiver 
                    if($receiver!=''){
                        //check if receiver exist
                        $statement=$conn->prepare("SELECT `user_id` FROM `users` WHERE`username`=?");
                        $statement->bind_param("s",$receiver);
                        $statement->execute();
                            
                        $sended_to=$statement->get_result();
                        $row=$sended_to->fetch_assoc();
                        if($row!=null){
  
                            //the receiver exist send the message
                            //insert message into the database
                            $sended_to_id=$row['user_id'];

                            if($statement=$conn->prepare("INSERT INTO `privatemsg` (`send_by`,`send_to`,`sender_username`,`message`) VALUE(?,?,?,?)")){
                                
                                $statement->bind_param("iiss",$sended_by_id,$sended_to_id,$sender,$message);
                                
                                if($statement->execute()){
                                    $response_['message']= 'Message sent successfully to user '.$receiver;
                                    $response_['type']='success';
                                }else{
                                    $response_['message']= 'Error executing the statement'.$statement;
                                    $response_['type']='error';
                                }                            
                            }else{
                                $response_['message']= 'Error with the statement failed'.$statement;
                                $response_['type']='error';
                            }
                        }else{
                            $response_['message']= 'User '.$receiver.'do not exist !!!';
                            $response_['type']='error';
                        }
                    }else{
                        //insert the message into the database 
                        $statement=$conn->prepare("INSERT INTO `groupchatmsg` (`send_by`,`username`,`message`) VALUE (?,?,?)");
                        $statement->bind_param('iss',$sended_by_id,$sender,$message);
                        
                        if($statement->execute()){
                            //proced query was succeffful
                            $response_['message']= 'Message was sent !!';
                            $response_['type']='success';
                        }else{
                            //error yet again
                            //$response_['message']= 'Error doing statement '.$statement.' with : '.$conn->error;
                            $response_['message']= 'Error can not process the query'.$conn->error;
                            $response_['type']='error';
                        }

                    }

                }else{
                    $response_['message']= 'Error you need to log in';
                    $response_['type']='error';
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
