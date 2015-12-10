<?php

$this->orgs['網站']  = [
                           'parent' => null
                       ];

$this->roles['網站'] = [
                           '管理員' => ['inhert' => null],
                                     
                           '版主'   => ['inhert' => null],
                                     
                           '使用者' => ['inhert' => null]
                       ];

$this->permissions= [
                        'orgs' => [
                                      '網站' => [
                                                    'roles' => [
                                                                   '管理員' => [
                                                                                   ['action'   => '移除',
                                                                                    'grant'    => 1,
                                                                                    'resource' => [
                                                                                                      'type' => '文章',
                                                                                                      'org'  => '單身俱樂部',
                                                                                                      'role' => '管理員',
                                                                                                      'id'   => 3
                                                                                                  ]
                                                                                   ],
                                                                                    
                                                                                   ['action'   => '編輯',
                                                                                    'grant'    => 1,
                                                                                    'resource' => [
                                                                                                      'type' => '文章',
                                                                                                      'org'  => null,
                                                                                                      'role' => null,
                                                                                                      'id'   => null
                                                                                                   ]
                                                                                   ]
                                                                               ]
                                                               ],
                                                
                                                        
                                                    'permissions' => [
                                                                        'action'   => '檢視',
                                                                        'grant'    => 1,
                                                                        'resource' => [
                                                                                          'type' => '文章',
                                                                                          'org'  => null,
                                                                                          'role' => null,
                                                                                          'id'   => null
                                                                                      ]
                                                                     ]
                                                ]
                                  ],
                                  
                        'users' => [
                                       '3' => [
                                                  'permissions' => [
                                                                       'action'   => '檢視',
                                                                       'grant'    => 1,
                                                                       'resource' => [
                                                                                         'type' => '文章',
                                                                                         'org'  => null,
                                                                                         'role' => null,
                                                                                         'id'   => null
                                                                                     ]
                                                                   ]
                                              ]
                                   ]
                    ];
                                                        



$this->users['1'] = [
                        '網站' => [
                                      'role' => '管理員'
                                  ]
                    ];


?>