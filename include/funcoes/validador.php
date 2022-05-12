<?php
//Verifica se está no formato YYYY-MM-DD
function verificaData( $data ) {
	if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $data)){
                return true;
        }
        return false;
}

//Verifica se está no formato YYYY-MM-DD HH:mm
function verificaDataHora( $data ) {
    if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (([0-1][0-9])|(2[0-3])):([0-5][0-9])$/', $data)){
                return true;
        }
        return false;
    }

function verificaDataHoraCompleta( $data ) {
    if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) (([0-1][0-9])|(2[0-3])):([0-5][0-9]):([0-5][0-9])$/', $data)){
                return true;
        }
        return false;
    }




?>