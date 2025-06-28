<?php
session_start();

session_unset();
session_destroy();

?>
<script>
	alert('로그아웃했습니다.');
	self.location.href='./index.php';
</script>