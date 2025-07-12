<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option_id'])) {
    $option_id = (int)$_POST['option_id'];

    // 중복 투표 방지
    $poll_id = $pdo->prepare("SELECT poll_id FROM options WHERE id = ?");
    $poll_id->execute([$option_id]);
    $poll = $poll_id->fetch();

    if (!$poll) {
        die("잘못된 선택입니다.");
    }

    if (isset($_SESSION['voted_poll_' . $poll['poll_id']])) {
        header("Location: index.php");
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO votes (option_id, session_id) VALUES (?, ?)");
    $stmt->execute([$option_id, session_id()]);

    $_SESSION['voted_poll_' . $poll['poll_id']] = true;
}

header("Location: index.php");
exit;

