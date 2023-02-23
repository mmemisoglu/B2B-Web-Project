<?php

require_once '../system/function.php';

if($_POST){
    
    $name  = post('name');
    $email  = post('email');
    $subject  = post('subject');
    $message  = post('message');
    


    if(!$name || !$email || !$message){
        echo 'empty';
    }else{
        if(strlen($message) < 100){
            echo "char";
        }else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                echo 'format';
            }else{
                $result = $db->prepare("INSERT INTO mesajlar SET
                    mesajisim   =:i,
                    mesajposta  =:p,
                    mesajkonu   =:k,
                    mesajicerik =:ic,
                    mesajip     =:ip
                ");
                $result->execute([
                    ':i'  => $name,
                    ':p'  => $email,
                    ':k'  => $subject,
                    ':ic' => $message,
                    ':ip' => IP()
                ]);
                if($result->rowCount()){
                    echo 'ok';
                }else{
                    echo 'error';
                }
            }
        }
    }
}

?>