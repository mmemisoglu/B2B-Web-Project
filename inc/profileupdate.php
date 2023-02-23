<?php

require_once '../system/function.php';

//Üye girişi yapmış olmalı ki güncelleme yapabilsin
if($_SESSION['login'] != sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $bname  = post('bname');
    $bmail  = post('bmail');
    $bphone = post('bphone');
    $bvno   = post('bvno');
    $bvd    = post('bvd');
    $bweb    = post('bweb');

   

    if(!$bname || !$bmail ||  !$bphone || !$bvno || !$bvd ){
        echo 'empty';
    }else{
        if(!filter_var($bmail,FILTER_VALIDATE_EMAIL)){
            echo 'format';
        }else{

        
            //Bu e-posta önceen kayıtlı mı değil mi
            $already = $db->prepare("SELECT bayikodu,bayimail FROM bayiler WHERE bayimail = :b AND bayikodu != :bayikodu ");
            $already->execute([
                ':b'=> $bmail,
                ':bayikodu' => $bcode
            ]);
            if($already->rowCount()){
                echo 'already';
            }else{

                $result = $db->prepare("UPDATE bayiler SET 
                
                bayiadi  =:bname,
                bayimail =:bmail,
                bayitelefon =:bphone,
                bayifax =:bfax,
                bayisite =:bweb,
                bayivergino =:bvno,
                bayivergidairesi =:bvd WHERE bayikodu = :kod AND id = :id
                ");

                $result->execute([
                
                ':bname' => $bname,
                ':bmail' => $bmail,
                ':bphone'=> $bphone,
                ':bfax'=> $bfax,
                ':bweb'=> $bweb,
                ':bvno'  => $bvno,
                ':bvd'   => $bvd,
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

}

?>