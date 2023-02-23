<?php

require_once '../system/function.php';

//Üye girişi yapmış olmalı ki güncelleme yapabilsin
if($_SESSION['login'] != sha1(md5(IP().$bcode))){
    go(site);
}
 
if($_POST){
    
    $comment  = post('commentcontent');
    $product  = post('productcode');
    


    if(!$comment || !$product){
        echo 'empty';
    }else{
        if(strlen($comment) < 500){
            echo "char";
        }else{
            $result = $db->prepare("INSERT INTO urun_yorumlar SET
            yorumbayi   =:b,
            yorumurun   =:t,
            yorumisim   =:s,
            yorumicerik =:tu,
            yorumdurum  =:n,
            yorumip     =:ba
            ");

            $result->execute([
                ':b'  => $bcode,
                ':t'  => $product,
                ':s'  => $bname,
                ':tu' => $comment,
                ':n'  => 2,
                ':ba' => IP()
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