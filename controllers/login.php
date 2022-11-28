<?php

    // session start
    session_start();
    // include DB connection
    include('./db.php');

    // declaring variables
    $username="";
    $password="";
    $response_=[];

    if($_SERVER['REQUEST_METHOD']==='POST'){

        //set variable
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        if(isset($_POST['username']) && isset($_POST['password'])){

            $statement=$conn->prepare("SELECT * FROM `users` WHERE`username`=?");
            $statement->bind_param("s",$username);
            $statement->execute();
            $result=$statement->get_result();
            $row=$result->fetch_assoc();

            if($row!=null){
                
                //Checking the password
                $statement=$conn->prepare("SELECT * FROM users WHERE `username`=? AND `password`=? ");
                $statement->bind_param("ss",$username,$password);
                $statement->execute();
                $result=$statement->get_result();
                $row=$result->fetch_assoc();
                
                if($row!=null){
                    
                    //set session variable
                    $_SESSION['user']=$username;
                    $response_['message']='Login Successfull : '.$username.'!!!';
                    $response_['type']='success';
                }else{//error password is not ok
                    $response_['message']='Error Password Incorrect !!';
                    $response_['type']='error';
                }
                
            }else{

                $response_['message']='Error Username Do not Exist !!!';
                $response_['type']='error';                
                    
            }
            
            echo json_encode($response_);
        }
    
    }else{
        $response_['message']='Registration Failed , fill the form properly!!';
        $response_['type']='success';
    }
?>
