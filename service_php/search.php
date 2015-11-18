<?php

require_once __DIR__ . "/vendor/autoload.php";

$term = $_GET["search"];
$return = [];

$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");
//$collection = $manager -> selectCollection('AR_CON','person_resume');
//$collection = new MongoDB\Collection($manager, "AR_CON.person_resume");
//$cursor = $collection -> find(array("$text" => array("$search" => "pmp")), array("projection" => array("Emplid" => 1)));

//$cursor = $collection -> findOne(array("Emplid" => "100010"));
///$count = $collection -> distinct("Emplid");

$filter = ['$text' => ['$search' => $term]];
$options = ['projection' => array('Emplid' => 1, "Name" => 1, "Job_History" => 1)];

$query = new MongoDB\Driver\Query($filter, $options);

$cursor = $manager->executeQuery('AR_CON.person_resume', $query);
foreach ($cursor as $document) {
    //var_dump($document);

    array_push($return,$document);
};
//echo "End";
    //var_dump($cursor);
   /*foreach ($cursor as $document) {
    var_dump($document);
    }*/

    print json_encode($return);

?>
