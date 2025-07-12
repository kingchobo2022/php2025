<?php
$array1 = [1, 2, 3];
$array2 = [4, 5];

$merged = [...$array1, ...$array2];

print_r($merged);