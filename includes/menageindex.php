<?php
declare(strict_types = 1);
require_once('../classes/MenageDocument.php');

$query_input = $_POST['data'];

$array_with_instructions = explode(',',$query_input);
$comand = $array_with_instructions[0];
$id = $array_with_instructions[1];
unset($array_with_instructions[0]); 
unset($array_with_instructions[1]); 

$md = new MenageDocument($array_with_instructions,'index');
$response = $md->insertIntoDoc($id);

if($response){
    echo "index ok ".$response;
}else{
    echo "index error: No token to insert";
}

?>