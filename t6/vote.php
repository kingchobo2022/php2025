<?php
session_start();

require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['option_id'])) {
	exit;
}

$option_id = (int) $_POST['option_id'];

$sql = "SELECT poll_id FROM options WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $option_id]);
$poll = $stmt->fetch();

if(!$poll) {
	die('잘못된 선택입니다.');
}

if (isset($_SESSION['voted_poll_'. $poll['poll_id']])) {
	header('Location: index.php');
	exit;
}

$sql = "INSERT INTO votes (option_id, session_id) values(:option_id, :session_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute([':option_id' => $option_id, ':session_id' => session_id() ]);

$_SESSION['voted_poll_'. $poll['poll_id']] = true;

header('Location: index.php');
