<?php

require 'vendor/autoload.php';

$m = new MongoClient();
$db = $m->selectDB('AR_CON');
//$collection = new MongoCollection($db, 'person_resume');

// search for fruits
//$fruitQuery = array('Type' => 'Fruit');

$result = $db->command(
    array(
        'text' => 'person_resume', //this is the name of the collection where we are searching
        'search' => 'sql', //the string to search
       // 'limit' => 5, //the number of results, by default is 1000
        'project' => Array( //the fields to retrieve from db
            'Emplid' => 1,
            'Name' => 1
        )
    )
  );

?>
