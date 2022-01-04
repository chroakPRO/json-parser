<?php 
declare(strict_types=1)


class DB extends PDO
{
  //Ansluter till databasen. 
  public function __construct(string $dbname = "")
  {
    try 
    {
        parent::__construct("mysql:host=localhost;dbname=$dbname;charset=utf8","root", "");
    }   
    catch (Exception $e) 
    {
        echo "<pre>" . print_r($e, 1) . "</pre>";
    }
  }
}

class Parser { 

    public function __construct(string $json_struct){
        
        $this->db = new DB();
        $this->json_struct =  $json_struct;
        $this->linked_list = new SplDoublyLinkedList();
        return $this;
    }
 
    
    

    public function crawler(){
        
        $json_decoded = json_decode($this->json_struct);
        for(int $i = 0; $i < count($this->json_struct["items"]); $i++){
            
            $this->id_main = $i;
            $this->id_hash = $json_struct["items"][$i]["id"];
            $this->username = $json_struct["items"][$i]["login"]["username"];
            $this->password = $json_struct["items"][$i]["login"]["password"];
            $this->name = $json_struct["items"][$i]["name"];
            

        }

    }
}
