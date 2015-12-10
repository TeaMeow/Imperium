<?php
include '../src/imperium.php';


$imperium = new Imperium();

$imperium->addOrg('網站')
         ->addRole('管理員')
         ->addRole('版主')
         ->addRole('使用者');
         
$imperium->org('網站')
         ->role('管理員')
         ->resType('文章')
         ->allow('新增');

exit(var_dump($imperium));
?>