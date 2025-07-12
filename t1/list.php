<?php
require_once 'config/db.php';

$completed = $_GET['completed'] ?? '';
$keyword = $_GET['keyword'] ?? '';

// xss 공격 대비
$keyword = htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');


$where = "";
if ($completed === "1" || $completed === "0") {
	$where = " WHERE is_completed=". $completed;
}

if ($keyword !== '') {
	if($where !== '') {
		$where .= " AND title like :search";
	} else {
		$where = " WHERE title like :search";
	}
}


$sql = "SELECT id, title, is_completed, created_at 
FROM todos $where
ORDER BY id ASC";

if($keyword) {

	$stmt = $pdo->prepare($sql);
	$searchTerm = "%{$keyword}%";
	$stmt->execute([':search' => $searchTerm]);
	$rs = $stmt->fetchAll();
} else {
	$rs = $pdo->query($sql);
}

?>
<h1>할일 관리</h1>
<a href="input.php">할일 등록</a>
<form method="get" name="sform" action="list.php">
<input type="text" name="keyword" value="<?= $keyword ?>" placeholder="검색어 입력"	>
<select name="completed">
	<option value="">완료여부선택</option>
	<option value="1" <?= $completed == "1" ? "selected" : "" ?>>완료</option>
	<option value="0" <?= $completed == "0" ? "selected" : "" ?>>미완료</option>
</select>
<button>검색</button>
</form>
<table border="1">
<tr>
	<th>번호</th>
	<th>타이틀</th>
	<th>처리여부</th>
	<th>등록일시</th>
</tr>		
<?php

foreach($rs as $row) {

	$is_completed = $row['is_completed'] ? '완료' : '미완료';
	echo "<tr>
		<td>{$row['id']}</td>
		<td><a href='edit.php?id={$row['id']}'>{$row['title']}</a></td>
		<td>{$is_completed}</td>
		<td>{$row['created_at']}</td>
	</tr>";
}

?>
</table>
