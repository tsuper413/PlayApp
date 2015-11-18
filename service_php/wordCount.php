<?php

require_once __DIR__ . "/vendor/autoload.php";

//$term = $_GET["search"];
$return = [];

$manager = new MongoDB\Driver\Manager("mongodb://127.0.0.1:27017");
//$collection = $manager -> selectCollection('AR_CON','person_resume');
//$collection = new MongoDB\Collection($manager, "AR_CON.person_resume");
//$cursor = $collection -> find(array("$text" => array("$search" => "pmp")), array("projection" => array("Emplid" => 1)));

//$cursor = $collection -> findOne(array("Emplid" => "100010"));
///$count = $collection -> distinct("Emplid");

//$filter = ['$text' => ['$search' => $term]];
//$options = ['projection' => array('Emplid' => 1, "Name" => 1, "Job_History" => 1)];

$map = "function map() {
    // get content of the current document
    var cnt = this.Job_History;
    // split the content into an array of words using a regular expression
    var words = cnt.match(/\w+/g);
    // if there are no words, return
    if (words == null) {
        return;
    }
    // for each word, output {word, count} pair
    for (var i = 0; i < words.length; i++) {
        emit({ word:words[i] }, { count:1 });
    }
}";

$reduce = "function reduce(key, counts) {
    var cnt = 0;
    // loop through call count values
    for (var i = 0; i < counts.length; i++) {
        // add current count to total
        cnt = cnt + counts[i].count;
    }
    // return total count
    return { count:cnt };
}";

//$query = new MongoDB\Driver\Query($filter, $options);

$cursor = $manager->executeCommand('AR_CON', new MongoDB\Driver\Command(["mapReduce" => "person_resume", "map" => $map, "reduce" => $reduce, "out" => ["inline" => 1]]));

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
