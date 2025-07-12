<?php
require_once 'config/db.php';

$sql = "SELECT id, title, is_completed, created_at 
FROM todos 
WHERE is_completed=0
ORDER BY id ASC";

$rs = $pdo->query($sql);

?>
<h1>할일 관리</h1>
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
		<td>". $row['id'] ."</td>
		<td>". $row['title'] ."</td>
		<td>". $is_completed ."</td>
		<td>". $row['created_at'] ."</td>
	</tr>";
}

?>
</table>
