<?php
include '../src/imperium.php';


$imperium = new Imperium();

$imperium->addOrg('網站')
         ->addRole('管理員')
         ->addRole('版主')
         ->addRole('使用者')
         ->caller(1);
         
$imperium->self()
         ->allow('編輯', '相簿', 13);
         
  

exit(var_dump($imperium->can('編輯', '相簿')));
?>