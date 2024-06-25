<?php

//the 3 following functions are for fomating text that goes to the fromt pages;
function remove_diacritics($str){
    $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
    return strtr( $str, $unwanted_array );
}

function format_subject($str){
    $chars = array("_"  => " ", "1"  => " I", "2"  => " II", "3"  => " III");
    $formated = strtr($str, $chars);
    $formated = ucwords($formated);
    return $formated;
}
function remove_extension($fileTitle){
    $newTitle = basename(($fileTitle), ".".pathinfo($fileTitle, PATHINFO_EXTENSION));
    return $newTitle;
}

//that one is for uploads, edits and deletions;
function handle_status_sessions($jsFunction, $sessionName){
    if( isset($_SESSION[$sessionName]) ){
        $sessionVal = $_SESSION[$sessionName];
        unset( $_SESSION[$sessionName] );
        return"<script> $jsFunction('" . $sessionVal . "') </script>";
    }else{
        return "";
    }
}

function single_result_query($mySqli, $query, $toBindValue){
    //maybe make it more flexible adding more 's' and values to bind
    $stmt = $mySqli->prepare($query);
    if($toBindValue){$stmt->bind_param('s', $toBindValue);}
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;
}

?>