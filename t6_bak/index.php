<?php
session_start();
require 'config/db.php';

$poll = $pdo->query("SELECT * FROM polls ORDER BY id DESC LIMIT 1")->fetch();
$options = $pdo->prepare("SELECT * FROM options WHERE poll_id = ?");
$options->execute([$poll['id']]);

$hasVoted = false;
if (isset($_SESSION['voted_poll_' . $poll['id']])) {
    $hasVoted = true;
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>투표 시스템</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h2 class="mb-4"><?= htmlspecialchars($poll['question']) ?></h2>

    <?php if ($hasVoted): ?>
        <div class="alert alert-info">이미 투표하셨습니다. 결과를 확인하세요.</div>
        <ul class="list-group">
            <?php
                $results = $pdo->prepare("SELECT o.option_text, COUNT(v.id) AS votes
                    FROM options o
                    LEFT JOIN votes v ON o.id = v.option_id
                    WHERE o.poll_id = ?
                    GROUP BY o.id");
                $results->execute([$poll['id']]);
                foreach ($results as $row):
            ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($row['option_text']) ?>
                    <span class="badge bg-primary rounded-pill"><?= $row['votes'] ?>표</span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <form action="vote.php" method="post">
            <?php foreach ($options as $option): ?>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="option_id" value="<?= $option['id'] ?>" id="option<?= $option['id'] ?>" required>
                    <label class="form-check-label" for="option<?= $option['id'] ?>">
                        <?= htmlspecialchars($option['option_text']) ?>
                    </label>
                </div>
            <?php endforeach; ?>
            <button class="btn btn-success mt-3">투표하기</button>
        </form>
    <?php endif; ?>
</body>
</html>
