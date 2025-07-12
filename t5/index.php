<?php

require_once 'vendor/autoload.php';

// 템플릿 로더 설정 Template loader Setting
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

// 데이터와 함께 템플릿 렌더링 Template randering
echo $twig->render('hello.html.twig', [
	'name' => 'Kingchobo',
	'is_admin' => true,
	'items' => ['Apple', 'Banana', 'Cherry']
]);

