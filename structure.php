<?php

$this->orgs['網站'] = ['parent'      => null,
                       'roles'       => [],
                       'permissions' => []];

$this->roles['網站'] = ['管理員' => ['permission' => [],
                                     'inhert'     => null],
                                     
                        '版主'   => ['permission' => [],
                                     'inhert'     => null],
                                     
                        '使用者' => ['permission' => [],
                                     'inhert'     => null]];

$this->permissions['網站'] = ['管理員' => [['action' => '移除',
                                            'grant'  => 1,
                                            'resource' => ['type' => '文章',
                                                           'org'  => '單身俱樂部',
                                                           'role' => '管理員'
                                                           'id'   => 3]]],
                              '版主'   => [[]]];



$this->users['1'] = ['網站' => ['role' => '管理員']];


?>