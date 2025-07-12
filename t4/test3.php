<?php
$data1 = ['a' => 1];
$data2 = ['b' => 2];

$merged = [...$data1, ...$data2];

print_r($merged);