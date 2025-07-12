<?php
require_once 'config/db.php';

$action = $_POST['action'] ?? '';
$todo_text = $_POST['todo_text'] ?? '';


$message = '';
// 할 일 추가
if($action == 'add' && $todo_text != '') {
	$todoText = htmlspecialchars($todo_text, ENT_QUOTES, 'UTF-8');

	$sql = "INSERT INTO todos (title, created_at) VALUES (:title, NOW())";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':title' => $todoText]);

		$message = '할 일이 추가되었습니다.';


	} catch (PDOException $e) {
		// echo "Insert Err : ". $e->getMessage();
		$message = '입력과정에 오류가 발생했습니다.';
	}

	header('Location: index.php');
	exit;
}

// 모든 할 일 삭제
if ($action == 'clear_all') {
	$sql = "DELETE FROM todos WHERE 1";
	$pdo->query($sql);	

	header('Location: index.php');
	exit;
}



$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

// 할일 완료/미완료 toggle
if ($action == 'toggle' && $id != '' && is_numeric($id))  {
	
	$sql = "UPDATE todos SET is_completed = 1 - is_completed WHERE id=:id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':id' => $id]);

		header('Location: index.php');
		exit;

	} catch (PDOException $e) {
		// echo "Update Err : ". $e->getMessage();
		$message = '수정과정에 오류가 발생했습니다.';
	}
}

// 할일 삭제
if ($action == 'delete' && $id != '' && is_numeric($id))  {
	$sql = "DELETE FROM todos WHERE id=:id";
	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':id' => $id]);

		header('Location: index.php');
		exit;

	} catch (PDOException $e) {
		// echo "Delete Err : ". $e->getMessage();
		$message = '삭제과정에 오류가 발생했습니다.';
	}
}



$sql = "SELECT * FROM todos ORDER BY id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$rs = $stmt->fetchAll();
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

		<?php if($message != ''): ?>
		<div class="message"><?= $message ?></div>
		<?php endif; ?>

        <form method="POST" action="index.php">
            <input type="text" name="todo_text" placeholder="새로운 할 일을 입력하세요" required>
            <button type="submit" name="action" value="add">추가</button>
        </form>

		<ul>
<?php
	foreach($rs AS $row):
?>			
			<li class="<?= $row['is_completed'] ? 'completed' : '' ?>">
				<span class="todo-text"><?= $row['title'] ?></span>
				<div class="actions">
					<a href="index.php?action=toggle&id=<?= $row['id'] ?>"><?= $row['is_completed'] ? '완료' : '미완료' ?></a>
					<a href="#" data-id="<?= $row['id'] ?>" class="delete">삭제</a>
				</div>
			</li>
<?php
	endforeach;
?>			

		</ul>

		<form action="index.php" method="POST" class="clear-all-form">
			<button type="submit" name="action" value="clear_all"
			onclick="return confirm('전체 할 일을 삭제하시겠습니까?')"
			>모든 할 일 삭제</button>
		</form>
	</div>

<script>
document.querySelectorAll('.delete').forEach((el) => {
	el.addEventListener("click", function(event){
		event.preventDefault();
		if(confirm('삭제하시겠습니까?')) {
			self.location.href='index.php?action=delete&id=' + el.dataset.id;
		}
	});	
});	
</script>	

</body>
</html>