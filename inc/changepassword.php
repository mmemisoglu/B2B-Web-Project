<?php

require_once '../system/function.php';

//Üye girişi yapmış olmalı ki güncelleme yapabilsin
if($_SESSION['login'] != sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $bpass  = post('password');
    $bpass2 = post('password2');
    $crypto = sha1(md5($bpass));

   

    if(!$bname || !$bmail ){
        echo 'empty';
    }else{
        if($bpass != $bpass2){
            echo 'match';
        }else{
        
            $result = $db->prepare("UPDATE bayiler SET 
            
            bayisifre =:s WHERE bayikodu = :kod AND id = :id
            ");

            $result->execute([
            ':s'   => $crypto,
            ':kod'=> $bcode,
            ':id'=> $bid
            ]);

            if($result){
                echo "ok";
            }else{
                echo "error";
            }

        } 
        
        
    }

}

?>