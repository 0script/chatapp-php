<?php

    // session start
    session_start();
    // include DB connection
    include('./db.php');

    // declaring variables
    $username="";
    $email="";
    $password="";
    $response_=[];

    if($_SERVER['REQUEST_METHOD']==='POST'){

        if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])){

            //set variable
            $username=$_POST['username'];
            $email=$_POST['email'];
            $password=$_POST['password'];

            $statement=$conn->prepare("SELECT * FROM `users` WHERE`username`=?");
            $statement->bind_param("s",$username);
            $statement->execute();
            $result=$statement->get_result();
            $row=$result->fetch_assoc();

            if($row!=null){
                $response_['message']='Error Username Already In Use !!!';
                $response_['type']='error';                
            }else{
                //Creation of the user
                $statement=$conn->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?)");
                $statement->bind_param("sss",$username,$email,$password);
                $statement->execute();
                
                //set session variable
                $_SESSION['user']=$username;
                
                $response_['message']='Account Created Succeffully';
                $response_['type']='success';
            }


        }
    
    }else{
        $response_['message']='Registration Failed , fill the form properly!!';
        $response_['type']='success';
    }

    echo json_encode($response_);
?>
