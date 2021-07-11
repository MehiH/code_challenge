<?php

class MenageDocument
{
    private $data;
    private $type;

    public function __construct($data,$type)
	{
		$this->data = $data;
		$this->type = $type;		
	}

    public function insertIntoDoc($id)
    {
        if(count($this->data) > 0){
            $token_to_save = implode(" ",$this->data);
            $file_name = "../documents/$id.txt";
            file_put_contents($file_name, $token_to_save);
            return $id;
        }else{
            return false;
        }
    }

    public function searchDoc($folder)
    {
        $matched_files = $this->getFilesWith($folder, $this->data);

        if($matched_files){
            return $matched_files;
        }else{
            return false;

        }
    }

    function getFilesWith($folder,$query_input, $extension = 'txt') {

        if($folder) {
            $foundArray = array();
            $result = "";
            
            foreach(glob($folder . sprintf("*.%s", $extension)) as $file) {
                $contents = file_get_contents($file);
                $response_arr = [];
                preg_match($query_input, $contents, $response_arr);
                if(count($response_arr) > 0 ){
                    $result .= " ".basename($file,'.txt');
                }
            }
    
            if($result != "") {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}