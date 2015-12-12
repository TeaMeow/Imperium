<?php
include '../src/imperium.php';


$imperium = new Imperium();

$imperium->addOrg('網站')
         ->addRole('管理員')
         ->addRole('版主')
         ->addRole('使用者')
         ->caller(1)
         ->org('網站')
         ->assign(['管理員', '版主']);
         
$imperium->self()
         ->resType('相簿')
         ->resId(3)
         ->allow('%');
         
  

exit(var_dump($imperium->resType('相簿')->resId(3)->cannot('d')));
?>