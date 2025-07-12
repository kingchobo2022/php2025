<?php

// $user = [
// 	"name" => "Martin",
// 	"age" => 12,
// 	"isAdmin" => true
// ];

// $json = json_encode($user); // PHP Array => JSON 문자열로 변환.

// echo $json;

// $json = '{"name":"Martin","age":12,"isAdmin":true}';
// $data = json_decode($json); // JSOn 문자열 => PHP 객체

// echo $data->isAdmin;

// $jsonData = file_get_contents("data.json");
// $data = json_decode($jsonData);
// echo $data->age;

header("Content-Type: application/json");

// $data = [
// 	"result" => "success"
// ]; // PHP 연관배열

// echo json_encode($data); // json문자열 변환

$json = '{ "result" : "success" }';

echo $json;