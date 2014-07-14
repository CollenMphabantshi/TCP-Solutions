<?php
    $json = $_SERVER['HTTP_JSON'];
    echo "JSON: \n";
    echo "--------------\n";
    var_dump($json);
    echo "\n\n";
 
    $data = json_decode($json);
    echo "Array: \n";
    echo "--------------\n";
    var_dump($data);
    echo "\n\n";
 
    $name = $data->name;
    $pos = $data->position;
    echo "Result: \n";
    echo "--------------\n";
    echo "Name     : ".$name."\n Position : ".$pos;
?>