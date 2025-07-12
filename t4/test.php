<?php
function sum($a, $b, $c) {
	return $a + $b + $c;
}

$args = [1, 2, 3];

echo sum(...$args); // => sum(1,2,3);