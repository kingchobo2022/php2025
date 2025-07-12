<?php
require_once 'config/db.php';

try {
	$id = 2;
	$sql = "DELETE FROM todos WHERE id=:id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		':id' => $id
	]);

	echo $id .' 번이 삭제되었습니다.';

} catch (PDOException $e){
	echo "DELETE 오류 발생 : ". $e->getMessage();
} 
