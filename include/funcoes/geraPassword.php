<?php

// funcao para gerar password randomico de 10 caracteres
function randomPassword() {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKMNOPQRSTUVWXYZ0123456789";
    $i = 0;
    $pass = '' ;
    while ($i <= 10) {
        $num = rand() % 60;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
} 

?>