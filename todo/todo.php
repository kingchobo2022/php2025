<?php
session_start(); // 모든 PHP 스크립트의 시작 부분에 세션을 시작합니다.

// 세션에 'todos' 배열이 없으면 초기화합니다.
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = [];
}

$message = ''; // 사용자에게 보여줄 메시지

// 1. 할 일 추가 처리
if (isset($_POST['action']) && $_POST['action'] === 'add' && !empty($_POST['todo_text'])) {
    $todoText = htmlspecialchars(trim($_POST['todo_text']));
    if ($todoText !== '') {
        $_SESSION['todos'][] = [
            'id' => uniqid(), // 고유 ID 생성
            'text' => $todoText,
            'completed' => false
        ];
        $message = '할 일이 추가되었습니다.';
    } else {
        $message = '할 내용을 입력해주세요.';
    }
}

// 2. 할 일 완료/미완료 토글 처리
if (isset($_GET['action']) && $_GET['action'] === 'toggle' && isset($_GET['id'])) {
    $idToToggle = $_GET['id'];
    foreach ($_SESSION['todos'] as &$todo) { // 참조로 배열 순회
        if ($todo['id'] === $idToToggle) {
            $todo['completed'] = !$todo['completed'];
            $message = '할 일 상태가 변경되었습니다.';
            break;
        }
    }
    // GET 요청 후 페이지 새로고침 시 중복 실행 방지를 위해 리디렉션
    header('Location: todo.php');
    exit();
}

// 3. 할 일 삭제 처리
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $idToDelete = $_GET['id'];
    $_SESSION['todos'] = array_filter($_SESSION['todos'], function($todo) use ($idToDelete) {
        return $todo['id'] !== $idToDelete;
    });
    // 배열 인덱스 재정렬 (선택 사항이지만 깔끔하게 유지)
    $_SESSION['todos'] = array_values($_SESSION['todos']);
    $message = '할 일이 삭제되었습니다.';
    // GET 요청 후 페이지 새로고침 시 중복 실행 방지를 위해 리디렉션
    header('Location: todo.php');
    exit();
}

// 4. 모든 할 일 삭제 처리 (세션 초기화)
if (isset($_POST['action']) && $_POST['action'] === 'clear_all') {
    $_SESSION['todos'] = [];
    $message = '모든 할 일이 삭제되었습니다.';
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP 세션 기반 할 일 관리</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0056b3;
            text-align: center;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        form {
            display: flex;
            margin-bottom: 20px;
        }
        form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }
        form button:hover {
            background-color: #0056b3;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        li.completed {
            text-decoration: line-through;
            color: #888;
            background-color: #e9ecef;
        }
        li .todo-text {
            flex-grow: 1;
            cursor: pointer;
        }
        li .actions a {
            text-decoration: none;
            color: #007bff;
            margin-left: 10px;
        }
        li .actions a.delete {
            color: #dc3545;
        }
        li .actions a:hover {
            text-decoration: underline;
        }
        .clear-all-form {
            text-align: center;
            margin-top: 20px;
        }
        .clear-all-form button {
            background-color: #dc3545;
        }
        .clear-all-form button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>나의 할 일 목록</h1>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="todo.php" method="POST">
            <input type="text" name="todo_text" placeholder="새로운 할 일을 입력하세요" required>
            <button type="submit" name="action" value="add">추가</button>
        </form>

        <?php if (empty($_SESSION['todos'])): ?>
            <p style="text-align: center;">아직 할 일이 없습니다. 새로운 할 일을 추가해보세요!</p>
        <?php else: ?>
            <ul>
                <?php foreach ($_SESSION['todos'] as $todo): ?>
                    <li class="<?php echo $todo['completed'] ? 'completed' : ''; ?>">
                        <span class="todo-text" onclick="window.location.href='todo.php?action=toggle&id=<?php echo $todo['id']; ?>'">
                            <?php echo $todo['text']; ?>
                        </span>
                        <div class="actions">
                            <a href="todo.php?action=toggle&id=<?php echo $todo['id']; ?>">
                                <?php echo $todo['completed'] ? '미완료' : '완료'; ?>
                            </a>
                            <a href="todo.php?action=delete&id=<?php echo $todo['id']; ?>" class="delete" onclick="return confirm('정말로 이 할 일을 삭제하시겠습니까?');">삭제</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <form action="todo.php" method="POST" class="clear-all-form">
                <button type="submit" name="action" value="clear_all" onclick="return confirm('정말로 모든 할 일을 삭제하시겠습니까?');">모든 할 일 삭제</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>