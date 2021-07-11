<?php
declare(strict_types = 1);

print_r($_POST['data']);exit;
$query_input = nl2br($_POST['query_input']);

$array_with_instructions = explode('<br />',$query_input);
$array_with_instructions = array_map('trim', $array_with_instructions);

$i = 1;
// foreach($array_with_instructions as $inst){
    
//     $file_name = "../documents/$i.txt";
//     file_put_contents($file_name, $inst);
//     $i++;
// }

for($i = 1;$i<=4;$i++){
    $file_name = "../documents/$i.txt";
    $contents = file_get_contents($file_name);
    $tokens = explode(' ',$contents);
    //print_r($tokens);exit;
    $value = in_array('te',$tokens);
    if($value){
        echo $value.' Exist </br>';
    }else{
        echo 'no </br>';
    }
    
}


try {

} catch (TypeError $e) {
	echo "Error!: ".$e->getMessage();
}


?>