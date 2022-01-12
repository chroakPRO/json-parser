<?php 
Namespace Controllers;

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
        $this->db = new \Database\DB;
        $this->json_struct =  $loaded_file;
        $this->linked_list = new \SplDoublyLinkedList();
    }
    
    
    
    /** ['Account Object Generator']
     * * JSON struct serializer
     * 
     * @param string $json_struct - //? return value from file_gets_contents()
     * @return \SplDoublyLinkedList - //? AccountDetail object.
     */
    public function objGenerator(string $json_struct): \SplDoublyLinkedList {
        
        $list_object = new \SplDoublyLinkedList();

        //
        $json_decoded = json_decode($json_struct);
        for($i = 0; $i < count($this->json_decoded["items"]); $i++){
            
            $struct = new \Model\AccountDetail();
            $struct->id_main = $i;
            $struct->id_hash = $json_decoded["items"][$i]["id"];
            $struct->username = $json_decoded["items"][$i]["login"]["username"];
            $struct->password = $json_decoded["items"][$i]["login"]["password"];
            $struct->name = $json_decoded["items"][$i]["name"];
            
            $list_object->push($struct);
            unset($struct);

        }
        return $list_object;
       
    } 

    /** ['Dupes']
     * * Bitwarden Login - duplicates
     * 
     * @param array $arr
     * 
     * @return \SplDoublyLinkedList $seralizedObj
     */   
    public function Dupes(\SplDoublyLinkedList $arr): array {

        // check if array contains duplicates
        $dupes = new \SplDoublyLinkedList();

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
     * @param \SplDoublyLinkedList $arr //? AccountDetail Object
     * 
     * @return array
     */
    public function jsonGen(\SplDoublyLinkedList $arr, array $seralized_obj): array{
        $jsonArr = [];

        for($i = 0; $i < count($arr); $i++){
            if(in_array($i, $seralized_obj) === false) { 
                $jsonArr["items"][$i] = array($arr[$i]["id_main"], $arr[$i]["id_hash"],
                                              $arr[$i]["username"], $arr[$i]["password"],
                                              $arr[$i]["name"], $arr[$i]["ref"]);
            }
        }
        return $jsonArr;
    }
    
    public function fileGen(string $filename, array $arr){
        return json_encode($arr);
    }
}




$file = file_get_contents("bitwarden_export.json");
$test = new Parser($file);

/** ['Account Object Generator']
 * * JSON struct serializer
 * 
 * @param string $json_struct - //? return value from file_gets_contents()
 * @return \SplDoublyLinkedList - //? AccountDetail object.
 */
$obj_gen = $test->objGenerator($test->json_struct);
$arrDupes = $test->Dupes($obj_gen);

$dupes_obj = $arrDupes[0];
$seralized_obj = $arrDupes[1];

$json_struct = $test->jsonGen($obj_gen, $seralized_obj);

$print_value = $test->fileGen("Hello", $json_struct);
echo $print_value;


