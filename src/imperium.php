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




    /***********************************************
    /***********************************************
    /************ C A N & C A N N O T **************
    /***********************************************
    /***********************************************

    /*
     */
    
    function can()
    {
        
    }
    
    function cannot()
    {
        
    }
    
    function assign()
    {
    }
}
?>