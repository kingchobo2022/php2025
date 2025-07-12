<?php
require_once 'config/db.php';

$title = '놀러가기';

$sql = "INSERT INTO todos (title, created_at) VALUES(
	:title, NOW())";

try {

	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':title' => $title
	]);

	echo $title .'가 추가되었습니다.';

} catch (PDOException $e){
	echo "INSERT 오류 발생 : ". $e->getMessage();
} 