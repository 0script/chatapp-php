<?php

    session_start();
    
    function printf_array($format, $arr){ 
        return call_user_func_array('printf', array_merge((array)$format, $arr)); 
    } 

    function return_msg($chatname){
        
        if( file_exists("db.php") && is_readable("db.php") && include("db.php")){
            
            if($chatname==='groupchat'){
                
                $parameters_='created_date';
                $statement=$conn->prepare('SELECT * FROM `groupchatmsg` ORDER BY ?');

                if($statement->bind_param('s',$parameters_) && $statement->execute()){

                    //we get the groupchat message
                    $results=$statement->get_result();
                    //$data=$results->fetch_all(MYSQLI_ASSOC);
                    $response_=[];
                    $response_['type']='';
                    $response_['data']=[];
    
                    if($results){
                        foreach($results as $row){
                            array_push($response_['data'],array(
    
                                'username'=>$row['username'],
                                'created_date'=>$row['created_date'],
                                'message'=>$row['message']
                            ));
                        }
    
                        //array_reverse($response_['data']);
    
                        $response_['type']='success';
    
                    }else{
                        $response_['type']='error';
                        $response_['data']=array('data'=>$data,'result'=>$results,'mysqlerrors'=>$conn->error);
                    }

                    $_SESSION['chat']='groupchat';
                    echo json_encode($response_);
                }
                
            }else if($chatname==='sendedmsg'){
                
                $statement=$conn->prepare(
                    'SELECT users.username ,
                        privatemsg.sended_date ,
                        privatemsg.message 
                        FROM privatemsg 
                        INNER JOIN users 
                        ON privatemsg.send_to=users.user_id 
                        AND privatemsg.sender_username=? 
                        ORDER BY sended_date'
                );
                
                
                if($statement->bind_param('s',$_SESSION['user']) && $statement->execute()){
                    
                    //we get the groupchat message
                    $results=$statement->get_result();
                    //$data=$results->fetch_all(MYSQLI_ASSOC);
                    $response_=[];
                    $response_['type']='';
                    $response_['data']=[];
    
                    if($results){
                        foreach($results as $row){
                            array_push($response_['data'],array(
    
                                'username'=>$row['username'],
                                'created_date'=>$row['sended_date'],
                                'message'=>$row['message']
                            ));
                        }
    
                        //array_reverse($response_['data']);
                        $response_['type']='success';
                    }else{
                        $response_['type']='error';
                        $response_['data']=array('data'=>$data,'result'=>$results,'mysqlerrors'=>$conn->error);
                        
                    }
                    $_SESSION['chat']='sendedmsg';
                    echo json_encode($response_);
                }

            }else if($chatname==='inboxesmsg'){
                
                $sender=$_SESSION['user'];
                //get the user id
                $statement=$conn->prepare("SELECT `user_id` FROM `users` WHERE`username`=?");
                $statement->bind_param("s",$sender);
                $statement->execute();

                $sended_by=$statement->get_result();
                $row=$sended_by->fetch_assoc();

                if($row!=null){
                    
                    $sended_by_id=$row['user_id'];

                    $statement=$conn->prepare(
                        'SELECT `sender_username`,
                            `sended_date`,
                            `message` 
                            FROM privatemsg
                            WHERE send_to=?
                            ORDER BY sended_date
                        '
                    );
                    
                    
                    if($statement->bind_param('i',$sended_by_id) && $statement->execute()){
                        
                        //we get the groupchat message
                        $results=$statement->get_result();
                        //$data=$results->fetch_all(MYSQLI_ASSOC);
                        $response_=[];
                        $response_['type']='';
                        $response_['data']=[];
        
                        if($results){
                            foreach($results as $row){
                                array_push($response_['data'],array(
        
                                    'username'=>$row['sender_username'],
                                    'created_date'=>$row['sended_date'],
                                    'message'=>$row['message']
                                ));
                            }
        
                            //array_reverse($response_['data']);
        
                            $response_['type']='success';
                        }else{
                            $response_['type']='error';
                            $response_['data']=array('data'=>$data,'result'=>$results,'mysqlerrors'=>$conn->error);
                        }
                        $_SESSION['chat']='inboxesmsg';
                        echo json_encode($response_);
                    }
                }

            }

        }
    
    }

    if($_SERVER['REQUEST_METHOD']==='POST'){
        
        
        if(isset($_POST['chatname'])){
            if(isset($_SESSION['user']) && $_SESSION['user']!='unknow'){
                return_msg($_POST['chatname']);
            }else{

                $response_=[];
                $response_['type']='success';
                $response_['data']=array(
                    'username'=>'Log in In ',
                    'created_date'=>'order to see message',
                    'message'=>'You need be loged in sir !!'
                );
                echo json_encode($response_);
            }
            
        }
    }
?>