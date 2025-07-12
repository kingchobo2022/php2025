<?php
require_once './config/db.php';

$title = $_POST['title'] ?? ''; 

// xss 공격 대비
$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

if( trim($title) == '') {
	die( "
	<script>
		alert('입력값이  비었습니다.');
		self.location.href='./list.php';
	</script>
	");
}

$sql = "INSERT INTO todos (title, created_at) 
VALUES (:title, NOW())"; // NOW() MySQL 내장함수

try {
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':title' => $title]);
	echo "
	<script>
		alert('정상적으로 할 일이 등록되었습니다.');
		self.location.href='./list.php';
	</script>
	";
}catch(PDOException $e) {
	echo "Insert 실패했습니다. : ". $e->getMessage();
}


