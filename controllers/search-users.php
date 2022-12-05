<?php
    //session_start();

    include('./db.php');

    function returnUsers($username){

        include('./db.php');
        
        if(
            $statement=$conn->prepare("SELECT users.username,
                users.created_date,
                count(groupchatmsg.message) as numb_message 
                FROM users 
                INNER JOIN groupchatmsg 
                ON groupchatmsg.send_by=users.user_id 
                WHERE users.username=?") &&
            $statement->bind_param('s',$username) &&
            $statement->execute()
        ){
            $results=$statement->get_result();
            $row=$results->fetch_assoc();
            
            if($row!=null){
                
                $username=$row['username'];
                $created_date=$row['created_date'];
                $message_numb=$row['numb_message'];

                echo <<<EOF
                    <div class="message-box">
                        <h5>$username <span>$created_date<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i></h5>
                        <p>
                            User $username is present on the platform since  $created_date and have sended $message_numb messages .
                        </p>
                    </div>
                EOF;

            }
        }else{
            echo 'Error durring sql statement ';
        }
    }

?>