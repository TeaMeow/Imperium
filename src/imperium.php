<?php

/**
* Imperium Class
*
* @category  Tools
* @package   Imperium
* @author    Yami Odymel <yamiodymel@gmail.com>
* @copyright Copyright (c) 2015
* @license   https://en.wikipedia.org/wiki/MIT_License MIT License
* @link      http://github.com/TeaMeow/Imperium
* @version   1.0
**/

session_start();

class Imperium
{
    private $org            = null;
    private $role           = null;
    private $user           = null;
    private $resOrg         = '%';
    private $resRole        = '%';
    private $resType        = '%';
    private $resId          = '%';
    
    private $alias          = [];
    
    public  $orgs           = [];
    public  $roles          = [];
    public  $users          = [];
    
    public  $permission     = [
                               'orgs'  => [],
                               'roles' => [],
                               'users' => []
                              ];
    
    private $currentPermission = [];
    

    
    function addOrg($org, $parent=null)
    {
        /** Add the org in the org array */
        $this->orgs[$org] = ['parent' => $parent];

        /** Add the org in the permission array */
        $this->permissions['orgs'][$org] = [
                                            'roles'       => [],
                                            'permissions' => []
                                           ];

        return $this;
    }
    
    
    
    
    
    function addRole($role, $inhert=null)
    {
        foreach((array)$role as $singleRole)
            $this->roles[$this->org][$role] = ['inhert' => $inhert];
        
        return $this;
    }
    
    /***********************************************
    /***********************************************
    /************** P O I N T I N G ****************
    /***********************************************
    /***********************************************
     */
    
    function org($org)
    {
        $this->org = $org;
        
        return $this;
    }
    
    function role($role)
    {
        $this->role = $role;
        
        return $this;
    }
    
    function caller($id)
    {
        $this->user = $id;
        
        return $this;
    }
    
    function self()
    {
        $this->org = null;
        $this->role = null;
        
        return $this;
    }
    
    
    /***********************************************
    /***********************************************
    /************* R E S O U R C E S ***************
    /***********************************************
    /***********************************************
     */
     
    function resOrg($org)
    {
        $this->resOrg = $org;
        
        return $this;
    }
    
    function resRole($role)
    {
        $this->resRole = $role;
        
        return $this;
    } 
    
    function resType($type)
    {
        $this->resType = $type;
        
        return $this;
    }
    
    function resId($id)
    {
        $this->resId = $id;
        
        return $this;
    }
    
    function resSave()
    {
        
    }
    
    function resLoad()
    {
        
    }
    
    function cleanRes()
    {
        $this->resOrg  = '%';
        $this->resRole = '%';
        $this->resType = '%';
        $this->resId   = '%';
        
        return $this;
    }
    
    
    
    /***********************************************
    /***********************************************
    /************ A L L O W & D E N Y **************
    /***********************************************
    /***********************************************
    
    
    /**
     * Allow
     */
    
    function alias($name, $actions)
    {
        $this->alias[$name] = $actions;
        
        return $this;
    }
    
    function allow($actions, $resType=null, $resId=null)
    {
        return $this->addPermission(true, $actions);
    }
    

    function deny($actions, $resType=null, $resId=null)
    {
        return $this->addPermission(false, $actions);
    }
    
    
    
    function addPermission($allow=true, $actions)
    {
        if(!$this->hasInitializedPermission)
            $this->initializePermission();
        
        $grant = $allow ? 'allow' : 'deny';
        
        foreach((array)$actions as $action)
        {
            $position = &$this->getPermissionPosition();

            $position[$grant][$action][$this->resType][] = $this->generateResource();
        }
        
        
        $this->cleanRes();
        
        return $this;   
    }
    
    function generateResource()
    {
        return ['org'  => $this->resOrg,
                'role' => $this->resRole,
                'id'   => $this->resId];
    }
    
    
    function &getPermissionPosition()
    {
        switch($this->detectPermission())
        {
            case 'org':
                return $this->permissions['orgs'][$this->org]['permissions'];
                break;
            
            case 'orgRole':
                return $this->permissions['orgs'][$this->org]['roles'][$this->role]['permissions'];
                break;
                
            case 'user':
                return $this->permissions['users'][$this->user]['permissions'];
                break;
        }
    }
    
    
    function getUserPermissionPosition()
    {
        
    }
    

    
    
    function initializePermission()
    {
        $permission = ['allow' => [], 
                       'deny'  => []];
        
        $position = &$this->getPermissionPosition();
        $position = &$permission;
        
        return $this;
    }
    
    function hasInitializedPermission()
    {
        $position = $this->getPermissionPosition();
        
        return isset($position);
    }
    
    function detectPermission()
    {
        if($this->org && !$this->role)
            return 'org';
        elseif($this->org && $this->role)
            return 'orgRole';
        elseif(!$this->org && $this->role)
            return 'role';
        else
            return 'user';
    }
    
    
    function allowed()
    {
        
    }
    
    function denied()
    {
        
    }
    
    function permissionList($allowedOnly=false)
    {
        if(!$this->user) return false;
        
        //remove allow if in deny list have one
        $list = ['allow' => [],
                 'deny'  => []];
        
        foreach($this->users[$this->user] as $org => $roles)
        {
            foreach((array)$roles as $role)
            {
                
                $permissions = $this->permissions['orgs'][$org]['roles'][$role]['permissions'];
                
                if(!isset($permissions))
                    continue;
                
                $list        = array_merge_recursive($list, $permissions);
            }
            
            $permissions = $this->permissions['orgs'][$org]['permissions'];
            $list        = array_merge_recursive($list, $permissions);
        }
        
        $permissions = $this->permissions['users'][$this->user]['permissions'];
        $list        = array_merge_recursive($list, $permissions);
        

        
        return $list;
                
    }

    function permissionListFilter($list, $allowed=true)
    {
        
    }


    /***********************************************
    /***********************************************
    /************ C A N & C A N N O T **************
    /***********************************************
    /***********************************************

    /*
     */
    
    function can($actions)
    {
        $can = true;
        
        /** If $can is false, just keep it as false */
        foreach((array)$actions as $action)
            $can = $can ? $this->searchPermission(true, $action) : false;
        
        return $can;
    }
    
    
    function searchPermission($allow=true, $action=null)
    {
        //TODO: 增進效能
        $position = $this->permissionList(true);

        $position = $allow ? $position['allow'] : $position['deny'];
        
        $condition = ['org'  => $this->resOrg,
                      'role' => $this->resRole,
                      'id'   => $this->resId];
                      
        $unconditional = ['org'  => '%',
                          'role' => '%',
                          'id'   => '%'];
       
        $has      = false;
       
        foreach([$position[$action], $position['%']] as $action)
            foreach((array)$action as $resType => $resources)
                foreach($resources as $resource)
                    if(($resType == $this->resType || $resType == '%') && ($resource === $condition || $resource === $unconditional))
                        $has = true;

        return $has;
    }
    
    function cannot($actions)
    {
        $cannot = true;
        
        
        foreach((array)$actions as $action)
        {
            $isAllowed = $this->searchPermission(true, $action);
            $isDenied  = $this->searchPermission(false, $action);
            
            $cannot = $cannot ? !(!$isDenied && $isAllowed) : true;
        }    

        return $cannot;
    }
    
    
    function hasInitializedUser($id)
    {
        return isset($this->users[$this->user]);
    }
    
    function initializeUser($id)
    {  
        $this->users[$this->user]['orgs']        = [];
        $this->users[$this->user]['permissions'] = [];
    }
    
    function assign($roles)
    {
        $org = &$this->users[$this->user][$this->org];
        
        if(!isset($org))
            $org = [];
        
        foreach($roles as $role)
            array_push($org, $role);
        
        return $this;
    }
}
?>