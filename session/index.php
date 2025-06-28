<?php
session_start();

$ses_id = $_SESSION['ses_id'] ?? '';

if($ses_id) {
?>
<p> 이 곳은 회원 공간입니다.</p>
<a href="logout.php">로그아웃</a>
<?php	
} else {
?>	
	<p>접근할 수 없습니다.</p>
	<a href="login.php">로그인</a>
<?php	
}