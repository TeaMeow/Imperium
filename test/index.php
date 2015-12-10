<?php
include 'src/imperium.php';


$imperium = new Imperium();

$imperium->addOrg('網站')
         ->addRole('管理員')
         ->addRole('版主')
         ->addRole('使用者');
         
$imperium->org('網站')
         ->role('管理員')
         ->allow('移除');

exit(var_dump($imperium));

?>