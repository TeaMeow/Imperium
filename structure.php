<?php

$this->orgs['網站']  = [
                           'parent' => null
                       ];

$this->roles['網站'] = [
                           '管理員' => ['inherit' => null],
                                     
                           '版主'   => ['inherit' => null],
                                     
                           '使用者' => ['inherit' => null]
                       ];

$this->permissions= [
                        'orgs' => [
                                      '網站' => [
                                                    'roles' => [
                                                                   '管理員' => [
                                                                                   'permissions' => [
                                                                                                        'allow' => [
                                                                                                                       '檢視' => [
                                                                                                                                     '文章' => [
                                                                                                                                                   [
                                                                                                                                                       'org'  => '單身俱樂部',
                                                                                                                                                       'role' => '管理員',
                                                                                                                                                       'id'   => 3
                                                                                                                                                   ],
                                                                                                                                                   
                                                                                                                                                   [
                                                                                                                                                       'org'  => '單身俱樂部',
                                                                                                                                                       'role' => '管理員',
                                                                                                                                                       'id'   => 5
                                                                                                                                                   ]
                                                                                                                                               ]
                                                                                                                                 ]
                                                                                                                   ],
                                                                                                        
                                                                                                        'deny'  => [
                                                                                                                       '刪除' => [
                                                                                                                                     '文章' => [
                                                                                                                                                   [
                                                                                                                                                       'org'  => '單身俱樂部',
                                                                                                                                                       'role' => '管理員',
                                                                                                                                                       'id'   => 3
                                                                                                                                                   ]
                                                                                                                                               ]
                                                                                                                                 ]
                                                                                                                   ]
                                                                                                    ]
                                                                               ]
                                                               ],
                                                
                                                        
                                                    'permissions' => [
                                                                        'allow' => [
                                                                                       '檢視' => [
                                                                                                     '文章' => [
                                                                                                                   [
                                                                                                                       'org'  => '單身俱樂部',
                                                                                                                       'role' => '管理員',
                                                                                                                       'id'   => 3
                                                                                                                   ]
                                                                                                               ]
                                                                                                 ]
                                                                                   ],
                                                                                   
                                                                        'deny'  => []
                                                                     ]
                                                ]
                                  ],
                                  
                        'users' => [
                                       '3' => [
                                                  'permissions' => [
                                                                       'allow' => [
                                                                                       '檢視' => [
                                                                                                     '文章' => [
                                                                                                                   [
                                                                                                                       'org'  => '單身俱樂部',
                                                                                                                       'role' => '管理員',
                                                                                                                       'id'   => 3
                                                                                                                   ]
                                                                                                               ]
                                                                                                 ]
                                                                                   ],
                                                                                   
                                                                        'deny'  => []
                                                                   ]
                                              ]
                                   ]
                    ];
                                                        



$this->users['1'] = [   
                        '網站' => ['管理員', '版主']
                    ];


?>