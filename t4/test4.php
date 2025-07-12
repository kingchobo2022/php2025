<?php
function greet($g1, $g2, $g3) {
	echo "$g1, $g2, and $g3";
}
$words = ["Hello", "Hi", "Hey"];
greet(...$words);
