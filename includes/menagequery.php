<?php
declare(strict_types = 1);
require_once('../classes/MenageDocument.php');

$query_input = '/'.$_POST['data'].'/';

$md = new MenageDocument($query_input,'query');
$response = $md->searchDoc('../documents/');

if($response){
    echo "query result".$response;
}else{
    echo "query result empty";
}


?>