<?php
include '../src/imperium.php';


$imperium = new Imperium();

$imperium->addOrg('網站')
         ->addRole('管理員')
         ->addRole('版主')
         ->addRole('使用者')
         ->caller(1);

$imperium->org('網站')
         ->assign('管理員');
         
$imperium->org('網站')
         ->role('使用者')
         ->alias('管理', ['編輯', '新增', '移除'])
         ->deny('管理', '%');         
         
$imperium->org('網站')
         ->alias('管理', ['編輯', '新增', '移除'])
         ->allow('管理', '%');
         


exit(var_dump($imperium->can('新增', '相簿')));
?>