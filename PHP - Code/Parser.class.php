<?php 
include "AccountModel.class.php";
include "Database.class.php";

class Parser { 
    
    //* PRIVATE DATA
    private object $json_decoded;

    //! PUBLIC DATA
    public object $test;
    
    /** ['Construct']
     * * First method after object creation
     * *
     * @param string $loaded_file //? file_get_content()
     */
    public function __construct(string $loaded_file){

        //? Creates database & data-structures.
        $this->db = new DB();
        $this->json_struct =  $loaded_file;
        $this->linked_list = new SplDoublyLinkedList();
                
    }
    
    
    
    /** ['Account Object Generator']
     * * JSON struct serializer
     * 
     * @param string $json_struct - //? return value from file_gets_contents()
     * @return SplDoublyLinkedList - //? AccountDetail object.
     */
    public function objGenerator(string $json_struct): SplDoublyLinkedList {
        
        $list_object = new SplDoublyLinkedList();

        //
        $json_decoded = json_decode($json_struct);
        for($i = 0; $i < count($this->json_decoded["items"]); $i++){
            try {
                // call a success/error/progress handler
                $struct = new AccountDetail();
                $struct->id_main = $i;
                $struct->id_hash = $json_decoded["items"][$i]["id"];
                $struct->username = $json_decoded["items"][$i]["login"]["username"];
                $struct->password = $json_decoded["items"][$i]["login"]["password"];
                $struct->name = $json_decoded["items"][$i]["name"];
                
                $list_object->push($struct);
                unset($struct);
            }
            catch (\Throwable $e) { // For PHP 7
            //! handle $e
            }  

        }
        return $list_object;
       
    } 

    /** ['Dupes']
     * * Bitwarden Login - duplicates
     * 
     * @param array $arr
     * 
     * @return SplDoublyLinkedList $seralizedObj
     */   
    public function Dupes(SplDoublyLinkedList $arr): array {

        // check if array contains duplicates
        $dupes = new SplDoublyLinkedList();

        $seralizedObj = [];
        for($i = 0; $i < count($arr); $i++){
            //* Checks if index is already dupe. efficency 
            if(in_array($i, $seralizedObj) !== false ){
                for($j = 1; $j < count($arr); $j++){
                    // SHA1 Hash
                    $sha1sum = [hash("sha1", $arr[$i]["name"]), hash("sha1", $arr[$j]["name"])];
                    // Compare checksum: string stringx
                    if ($sha1sum[0] == $sha1sum[1]) {
                        $dupes->push($arr[$i]);
                        $seralizedObj[$i] = $i;
                        break;
                    }
                }
            }        
        }  
        // * Returns an array with AccountDetail Objects.
        return array($dupes, $seralizedObj);
    }

    /**
     ** Generate the new JSON without duplicates.
     * @param SplDoublyLinkedList $arr //? AccountDetail Object
     * @param array $seralizedObj //? Index:s that are duplicates
     * @param bool $database //? True or False if you want database upload.
     * 
     * @return array
     */
    public function jsonGen(SplDoublyLinkedList $arr, array $seralized_obj, bool $database): array{
        $jsonArr = [];

        for($i = 0; $i < count($arr); $i++){
            if(in_array($i, $seralized_obj) === false) { 
                $jsonArr["items"][$i] = array($arr[$i]["id_main"], $arr[$i]["id_hash"],
                                              $arr[$i]["username"], $arr[$i]["password"],
                                              $arr[$i]["name"], $arr[$i]["ref"]);
                if($database === true){
    
                    $query = "INSERT INTO cryptoguard(id_main, id_hash, username, password, name) VALUES (?, ?, ?, ?, ?)";
                    //Prepared statment
                    $sth = $this->db->prepare($query);
                    //Binder parametrar.
                    $sth->bindParam(1, $arr[$i]["id_main"]);
                    $sth->bindParam(2, $arr[$i]["id_hash"]);
                    $sth->bindParam(3, $arr[$i]["username"]);
                    $sth->bindParam(4, $arr[$i]["password"]);
                    $sth->bindParam(5, $arr[$i]["name"]);

                    //Fel hantering.
                    if ($sth->execute())
                    {
                        $sth->setFetchMode(\PDO::FETCH_ASSOC);
                        $results = $sth->fetchAll();
                        //Om det inte finns någon information att visa, skicka dom tillbaka till index.php
            
                        if ($results)
                        {
                            return $results;
                        }
                        else 
                        {
                            header ("Location: ../../../../Index.php?error=reponotfound");
                            exit();      
                        }
                    }
                    else
                    {
                        //Annars skriv ut fel kod.
                        echo "asdfpoasdkfoapsdkpoaskda";
                        echo "<h4>Error</h4>";
                        echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
                    }
                }
            }
        }
        return $jsonArr;
    }
    
    public function fileGen(string $filename, array $arr){
        return json_encode($arr);
    }


}




