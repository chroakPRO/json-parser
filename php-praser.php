<?php 
declare(strict_types=1)

public class AccountStruct {

    public string $id_main;
    public string $id_hash;
    public string $username;
    public string $password;
    public string $name;

    public function __construct(
        string $id_main, 
        string $id_hash, 
        string $username, 
        string $password, 
        string $name) 
    {
        $this->id_main = $id_main;
        $this->id_hash = $id_hash;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }
}

class Parser { 

    public function __construct(
        string $json_struct,         
        string $id_main, 
        string $id_hash, 
        string $username, 
        string $password, 
        string $name)){

            $this->id_main = $id_main;
            $this->id_hash = $id_hash;
            $this->username = $username;
            $this->password = $password;
            $this->name = $name;
    }

    public function crawler(){
        
        $json_decoded = json_decode($this->json_struct);
        for(int $i = 0; $i < count($this->json_struct["items"]); $i++){
            
            $this->id_main = $i;
            $this->id_hash = hash("sha256", $i * 48)
            $this->username = $

        }

    }




}
