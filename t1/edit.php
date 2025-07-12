<?php
require_once 'config/db.php';

$id = $_GET['id'] ?? '';

if($id == '' || !is_numeric($id) ) {

	echo "
		<script>
			alert('접근에 필요한 ID값이 없습니다.');
			self.location.href='./list.php';
		</script>
	";
	exit;
}

$sql = "SELECT id, title, is_completed 
FROM todos WHERE id=:id";

try {
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':id' => $id]);

	$row = $stmt->fetch();

}catch(PDOException $e) {
	echo "Select 오류 발생 : ". $e->getMessage();
	exit;
}

if(!$row) {
	echo "
		<script>
			alert('데이터가 삭제되었거나 존재하지 않습니다.');
			self.location.href='./list.php';
		</script>
	";
	exit;	
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>할 일 관리 - 수정</title>
</head>
<body>
	<form method="post" action="edit_ok.php">
		<input type="hidden" name="id" value="<?= $id ?>">
		할 일 : <input type="text" name="title" value="<?= $row['title'] ?>"> <br>
		처 리 : <select name="is_completed">
			<option value="0" <?= ($row['is_completed'] == 0) ? 'selected' : ''; ?>>미처리</option>
			<option value="1" <?= ($row['is_completed'] == 1) ? 'selected' : ''; ?>>처리완료</option>
		</select>
		<button type="submit">수정완료</button>
	</form>
</body>
</html>

