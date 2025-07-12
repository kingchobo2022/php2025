<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
	$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<form method="post" action="submit.php">
	<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
	이름 : <input type="text" name="name"><br>
	<button>전송</button>
</form>