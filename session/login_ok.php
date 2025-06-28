<?php

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if($username == 'admin' && $password == '4321') {
	session_start();

	$_SESSION['ses_id'] = $username;

	echo "
	<script>
		alert('로그인에 성공했습니다.');
		self.location.href='./index.php';
	</script>
	";

} else {
?>
	<p>아이디와 비번 입력이 바르지 않습니다.</p>
	<a href="login.php">로그인으로 이동</a>
<?php
}
