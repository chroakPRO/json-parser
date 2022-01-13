<?php
//include "Parser.class.php";
include "DB.class.php";

//$file = file_get_contents("bitwarden_export.json");
//$test = new Parser($file);

$conn =  new DB();
$id = 1;
$title = "test";
$link = "test";
$desc = "tes";
$lang = "test";


$query = "INSERT INTO cryptoguard(id_main, id_hash, username, password, name) values (?, ?, ?, ?, ?)";
//Vi köra en bindParam för varje ?.    
$sth = $conn->prepare($query);
$sth->bindParam(1, $id);
$sth->bindParam(2, $title);
$sth->bindParam(3, $link);
$sth->bindParam(4, $desc);
$sth->bindParam(5, $lang);
//Om koden går igenom retunera resultatet.    
   if ($sth->execute())
   {
       return $sth;
   }
   else
   {
       //Annars skriv ut fel kod.
       echo "<h4>Error</h4>";
       echo "<pre>" . print_r($sth->errorInfo(), 1) . "</pre>";            
   }





/** ['Account Object Generator']
 * * JSON struct serializer
 * 
 * @param string $json_struct - //? return value from file_gets_contents()
 * @return SplDoublyLinkedList - //? AccountDetail object.
 */

/*
$obj_gen = $test->objGenerator($test->json_struct);
$arrDupes = $test->Dupes($obj_gen);

$dupes_obj = $arrDupes[0];
$seralized_obj = $arrDupes[1];

$json_struct = $test->jsonGen($obj_gen, $seralized_ob, true);

$print_value = $test->fileGen("Hello", $json_struct);
echo $print_value;*/


?>