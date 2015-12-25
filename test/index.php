<?php
include '../src/imperium.php';


$imperium = new Imperium();

$imperium->caller(1);

$imperium->self()
         ->allow('編輯', ['文章', '相簿']);



exit(var_dump($imperium->cannotAny('編輯', ['文章'])));
?>