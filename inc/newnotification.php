<?php

require_once '../system/function.php';

//Üye girişi yapmış olmalı ki güncelleme yapabilsin
if($_SESSION['login'] != sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    
    $hbank    = post('hbank');
    $hdate    = post('hdate');
    $hhour    = post('hhour');
    $hprice   = post('hprice');
    $hdesc    = post('hdesc');
    
    if(!$hbank || !$hdate || !$hhour || !$hprice){
        echo 'empty';
    }else{
        if(!is_numeric($hprice)){
            echo "number";
        }else{
            $result = $db->prepare("INSERT INTO havalebildirim SET
            havalebayi =:b,
            havaletarih =:t,
            havalesaat =:s,
            havaletutar =:tu,
            havalenot =:n,
            banka =:ba,
            havaleip =:i
            ");

            $result->execute([
                ':b' => $bcode,
                ':t' => $hdate,
                ':s' => $hhour,
                ':tu' => $hprice,
                ':n' => $hdesc,
                ':ba' => $hbank,
                ':i' => IP()
            ]);
            if($result->rowCount()){
                echo 'ok';
            }else{
                echo 'error';
            }
        }
    }
}

?>