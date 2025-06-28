<?php
session_start();

if(!isset($_SESSION['todos'])) {
	$_SESSION['todos'] = [];
}

$message = ''; // 사용자에게 보여줄 메시지

// 할일 추가
if (isset($_POST['action']) && $_POST['action'] === 'add' && !empty($_POST['todo_text'])) {
	$todoText = htmlspecialchars(trim($_POST['todo_text']));
	if($todoText !== '') {
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

// 할일 완료 / 미완료 토글 처리
if (isset($_GET['action']) && $_GET['action'] == 'toggle' && isset($_GET['id'])) {
	$idToToggle = $_GET['id'];
	foreach($_SESSION['todos'] as &$todo) {
		if($todo['id'] === $idToToggle) {
			$todo['completed'] = !$todo['completed'];
			$message = '할일의 상태가 변경되었습니다.';
			break;
		}
	}

	header('Location: todo.php');
	exit;
}



// 할일 삭제
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
	$idTodDelete = $_GET['id'];
	$_SESSION['todos'] = array_filter($_SESSION['todos'], function($todo) use ($idTodDelete){
		return $todo['id'] !== $idTodDelete;
	});
	header('Location: todo.php');
	exit;
}

// 모든 할 일 삭제
if(isset($_POST['action']) && $_POST['action'] === 'clear_all') {
	$_SESSION['todos'] = [];
	$message = '모든 할 일이 삭제되었습니다.';
}

?>
<html lang="ko"><head>
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
		<?php if($message){ ?>
		<div class="message"><?php echo $message; ?></div>
		<?php } ?>		
        <form action="todo.php" method="POST">
            <input type="text" name="todo_text" placeholder="새로운 할 일을 입력하세요" required>
            <button type="submit" name="action" value="add">추가</button>
        </form>

		<ul>
			<?php if(empty($_SESSION['todos'])){ ?>
			<p class="text-algin:center">아직 할일이 없습니다. 새로운 할 일을 추가해 보세요!</p>
			<?php } else { ?>
			<?php
			foreach($_SESSION['todos'] as $todo): ?>
			<li <?php echo $todo['completed'] ? 'class="completed"': '' ?>>
				<span class="todo-text" data-id="<?php echo $todo['id']; ?>"><?php echo $todo['text']; ?></span>
				<div class="actions">
					<a href="todo.php?action=toggle&id=<?php echo $todo['id']; ?>"><?php echo $todo['completed'] ? '미완료':'완료'; ?></a>
					<a href="#" class="delete" data-id="<?php echo $todo['id']; ?>">삭제</a>
				</div>
			</li>
			<?php endforeach; ?>

			<?php } ?>
		</ul>

		<form action="todo.php" method="POST" class="clear-all-form">
			<button type="submit" name="action" value="clear_all" onclick="return confirm('정말로 모든 할 일을 삭제하시겠습니까?')">모든 할 일 삭제</button>
		</form>
	</div>
<script>
document.querySelectorAll('.delete')?.forEach((el) => {
	el.addEventListener("click", function(event) {
		event.preventDefault();
		if(confirm('삭제하시겠습니까?')) {
			self.location.href='todo.php?action=delete&id=' + el.dataset.id;
		}
	});
});
document.querySelectorAll('.todo-text')?.forEach( (el) => {
	el.addEventListener("click", function() {
		self.location.href = 'todo.php?action=toggle&id=' + el.dataset.id;
	});
});
</script>	
</body>
</html>