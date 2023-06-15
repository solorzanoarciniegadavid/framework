<?php


function getData(){
    //get data from an api
    $data = file_get_contents('https://api.covid19api.com/summary');
    return $data;
}


?>