<?php
require_once "./config/db.php";

try {
	$sql = "CREATE TABLE IF NOT EXISTS todos(
		id int auto_increment primary key,
		title varchar(255) not null,
		is_completed tinyint not null default 0,
		created_at datetime
	)";
	// 테이블 삭제
	//$sql = "DROP TABLE todos";

	$pdo->exec($sql);
} catch(PDOException $e) {
	echo "테이블 생성 오류 : ". $e->getMessage();
}

$pdo = null;
