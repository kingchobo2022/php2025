<?php

require_once('config/db.php');

//$sql = "CREATE DATABASE firstdb";
$sql = "DROP DATABASE firstdbx";
try {
  $pdo->exec($sql);
} catch(PDOException $e) {
  echo "디비를 삭제할 수 없습니다. : ". $e->getMessage();
}


$pdo = null;

// 생성되어 있는 데이터베이스 목록을 보여주는 SQL
// show databases;

// 데이터베이스 생성
// CREATE DATABASE 데이터베이스명;

// 데이터베이스 삭제
// DROP DATABASE 데이터베이스명;
