<?php
// if(isset($_SESSION['chat'])){
//     if($_SESSION['chat']=='groupchat'){
        
//         $results=$conn->query("SELECT * FROM `groupchatmsg` ORDER BY created_date DESC ");

//         if($results->num_rows===0){
//             echo <<<EOF
//                     <div class="message-box">

//                         <h5>No message <span>timestamp<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
//                         <p>
//                             WOW SUCH AN EMPTY PLACE !!!
//                         </p>
//                     </div>
//             EOF;
//         }else{
//             //HERE YOU PROCESS 
//             foreach($results as $row){
//                 echo '
//                     <div class="message-box">
//                         <h5>'.$row['username'].'<span>'.$row['created_date'].'<span> <i title="Reply" class="fa-sharp fa-solid fa-reply"></i> </h5>
//                         <p>'.$row['message'].'</p>
//                     </div>
//                 ';
//             }
            
//         }

//     }//continue with else if chat==sended
// }
?>


function sendmessage(){
                
                let receiver=document.getElementById('sendto').value.trim();
                let message=document.getElementById('post').value.trim();

                if(message!=''){

                    let obj=`message=${message}&receiver=${receiver}`;
                    let url_success=window.location.protocol+'//www.'+window.location.hostname+'/index.php?info=sendedOK';
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
