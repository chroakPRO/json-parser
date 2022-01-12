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
<<<<<<< HEAD
     * @return \SplDoublyLinkedList $seralizedObj
     */
    public function Dupes(array $arr): \SplDoublyLinkedList {
=======
     * @return array $serializedObj
     */
    function duplicateNumber(\SplDoublyLinkedList $arr): \SplDoublyLinkedList {
>>>>>>> 6e57d37cfaa9a74d04377bd95ff31bfb333167e9
        
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
<<<<<<< HEAD
                        $count[$i] = $i;
                        
                    }
                }
            }
        }
    
        return $dupes;
    }
}
}


=======
                        $seralizedObj[$i] = $i;
                        break;
                    }
                }
            }        
        }  
        // * Returns an array with AccountDetail Objects.
        return $dupes;
    }
}


$file = file_get_contents("bitwarden_export.json");
$test = new Parser($file);
/*
* objGenerator returns a SplDoublyLinkedList.
* 1 line contains 1 object. Values are seperated by ###
* 
*/
$test = $test->objGenerator($test->json_struct);
>>>>>>> 6e57d37cfaa9a74d04377bd95ff31bfb333167e9
