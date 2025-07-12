<?php
$defaults = ['host' => 'localhost', 'port' => 3306];
$custom = ['port' => 3307];

$config = [...$defaults, ...$custom];

print_r($config);