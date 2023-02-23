<?php

require_once '../system/function.php';

//Üye girişi yapmış olmalı ki güncelleme yapabilsin
if($_SESSION['login'] != sha1(md5(IP().$bcode))){
    go(site);
}

if($_POST){
    $title      = post('title');
    $content    = post('content');

    if(!$title || !$content){
        echo 'empty';
    }else{
            $result = $db->prepare("INSERT INTO bayi_adresler SET 
            adresbaslik =:s, 
            adrestarif  =:t, 
            adresbayi   =:b, 
            adresdurum  =:d 
            ");

            $result->execute([
            ':s'    => $title,
            ':t'    => $content,
            ':b'    => $bcode,
            ':d'    => 1
            ]);

            if($result->rowCount()){
                echo "ok";
            }else{
                echo "error";
            }
    }
}

?>