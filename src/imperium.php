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
    private $resOrg         = null;
    private $resRole        = null;
    private $resType        = null;
    private $resId          = null;
    
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
        
        foreach((array)$actions as $action)
        {
            $position = &$this->getPermissionPosition();

            $position[$action][$this->resType][] = $this->generateResource();
        }
        
    }
    
    function generateResource()
    {
        return ['org'  => $this->org,
                'role' => $this->role,
                'id'   => $this->id];
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
            return false;
    }
    
    
    function allowed()
    {
        
    }
    
    function denied()
    {
        
    }
    
    function permissionList()
    {
        if(!$this->user) return false;
        
        $list = ['allow' => [],
                 'deny'  => []];
        
        foreach($this->users[$this->user] as $org => $roles)
        {
            foreach((array)$roles as $role)
            {
                $permissions = $this->orgs[$org]['roles'][$role]['permissions'];
                $list        = array_merge_recursive($list, $permission);
            }
            
            $permission = $this->orgs[$org]['permissions'];
            $list        = array_merge_recursive($list, $permission);
        }
        
        return $list;
                
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
            $can = (!$can) ? $this->searchPermission(true, $action) : false;
        
        return $can;
    }
    
    
    function searchPermission($allow=true, $action=null)
    {
        $position = $this->permissionList();
        $position = $allow ? $position['allow'] : $position['deny'];
        $has      = false;
        
        /** Return false if the action wasn't in the permission list */
        if(!isset($position[$action]))
            return false;

        
        return $has;
    }
    
    function cannot()
    {
        
    }
    
    function assign($roles)
    {
        if(!isset($this->users[$this->user][$this->org]))
            $this->users[$this->user][$this->org] = [];
        
        array_push($this->users[$this->user][$this->org], $roles);
        
        return $this;
    }
}
?>