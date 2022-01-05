<?php 
Namespace Controllers;

class Parser { 
    
    public function __construct(string $json_struct){
        
        $this->db = new \Database\DB;
        $this->json_struct =  $json_struct;
        $this->linked_list = new \SplDoublyLinkedList();
        return 12;
    }
    
    
    
    public function crawler(){
        
        $json_decoded = json_decode($this->json_struct);
        for($i = 0; $i < count($this->json_decoded["items"]); $i++){
            
            $this->id_main = $i;
            $this->id_hash = $json_decoded["items"][$i]["id"];
            $this->username = $json_decoded["items"][$i]["login"]["username"];
            $this->password = $json_decoded["items"][$i]["login"]["password"];
            $this->name = $json_decoded["items"][$i]["name"];
            
            $list_object = new \SplDoublyLinkedList;
            $str_object = "$this->id_main## 
                            $this->id_hash##
                            $this->username##
                            $this->password##
                            $this->name";

            $list_object->push($str_object);
            
        }
        
    }
}
?>
