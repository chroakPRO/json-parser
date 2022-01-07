<?php 
Namespace Controllers;

class Parser { 
    
    //* PRIVATE DATA
    private object $json_decoded;

    //! PUBLIC DATA
    public object $test;
    
    /** ['Construct']
     * * First method after object creation
     * @param string $loaded_file
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
     * @param string $json_struct 
     * @return \SplDoublyLinkedList
     */
    public function objGenerator(string $json_struct): \SplDoublyLinkedList {
        
        // 
        $json_decoded = json_decode($json_struct);
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

        return $list_object;
       
    } 

    /** ['Dupes']
     * * Bitwarden Login - duplicates
     * 
     * @param array $arr
     * 
     * @return array $seralizedObj
     */
    function duplicateNumber(array $arr): array {
        
        // check if array contains duplicates
        $dupes = new \SplDoublyLinkedList();

        $count = [];
        
        // for: compare every value with eachother. O(n^2)
        for($i = 0; $i < count($arr); $i++){
            // if: if index value is in array 
            if(in_array($i, $count) === false){
                for($j = $i + 1; $j < count($arr); $j++){
                    if(in_array($i, $count) === false){

                    // SHA1 Hash
                    $sha1sum = [hash("sha1", $arr[$i]["name"]), hash("sha1", $arr[$j]["name"])];
                    
                    // Compare checksum: string stringx
                    if ($sha1sum[0] == $sha1sum[1]) {
                        $dupes->push($arr[$i]);
                        $count[$i] = $i;
                        break;
                    }
                }
            }
        }
    
        return item;
    }
}
?>
