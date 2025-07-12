<?php
require_once 'config/db.php';


$id = $_POST['id'] ?? '';
$is_completed = $_POST['is_completed'] ?? '';
$title = $_POST['title'] ?? '';

// xss 공격 대비
$title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');


if($id == '' || !is_numeric($id) ) {

	echo "
		<script>
			alert('접근에 필요한 ID값이 없습니다.');
			self.location.href='./list.php';
		</script>
	";
	exit;
}

if( trim($title) == '') {
	echo "
		<script>
			alert('할 일이 빠져 있어 수정하지 못합니다.');
			history.go(-1);
		</script>
	";
	exit;
}

$sql = "UPDATE todos 
SET title=:title, is_completed=:is_completed 
WHERE id=:id";
try{
	$stmt = $pdo->prepare($sql);
	$arr  = [
			':title' => $title, 
			':is_completed' => $is_completed,
			':id' => $id
	    ];

	$stmt->execute($arr);

	echo "
		<script>
			self.location.href='list.php';
		</script>
	";
	exit;

}catch(PDOException $e) {
	echo "Update 오류발생 : ". $e->getMessage();
}

