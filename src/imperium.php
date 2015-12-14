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
    /**
     * Organization pointer
     * 
     * @var null|string
     */
     
    private $org            = null;
    
    /**
     * Role pointer
     * 
     * @var null|string
     */
     
    private $role           = null;
    
    /**
     * User pointer
     * 
     * @var null|string
     */
     
    private $user           = null;
    
    /**
     * Organization pointer of the resource
     *
     * @var string
     */
     
    private $resOrg         = '%';
    
    /**
     * Role pointer of the resource
     *
     * @var string
     */
     
    private $resRole        = '%';
    
    /**
     * Type pointer of the resource
     *
     * @var string
     */
     
    private $resType        = '%';
    
    /**
     * Identifier pointer of the resource
     *
     * @var string
     */
     
    private $resId          = '%';
    
    /**
     * Stores the aliases
     * 
     * @var array
     */
     
    private $alias          = [];
    
    /**
     * Stores the organizations
     * 
     * @var array
     */
     
    public  $orgs           = [];
    
    /**
     * Stores the roles of the organizations
     * 
     * @var array
     */
     
    public  $roles          = [];
    
    /**
     * Stores the users and which organizations they belong
     * 
     * @var array
     */
     
    public  $users          = [];
    
    /**
     * Stores the permissions of the organizations and the users
     * 
     * @var array
     */
     
    public  $permission     = [
                                  'orgs'  => [],
                                  'roles' => [],
                                  'users' => []
                              ];

    
    
    
    /**
     * Add a single organization
     * 
     * @param string $org      The name of the organization.
     * @param string $parent   The parent organization of the organization.
     * 
     * @return Imperium
     */
    
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
    
    
    
    
    /**
     * Add roles
     * 
     * @param array|string $roles     The names of the roles.
     * @param string       $inherit   The name of the role which the roles should inherit from.
     * 
     * @return Imperium
     */
    
    function addRole($roles, $inherit=null)
    {
        foreach((array)$roles as $singleRole)
            $this->roles[$this->org][$role] = ['inherit' => $inherit];
        
        return $this;
    }
    
    
    
    
    /***********************************************
    /***********************************************
    /************** P O I N T I N G ****************
    /***********************************************
    /***********************************************
    
    /**
     * Organization selector
     * 
     * @param string $org   The name of the organization you want to select.
     * 
     * @return Imperium
     */
    
    function org($org=null)
    {
        $this->org = $org;
        
        return $this;
    }
    
    
    
    
    /**
     * Role selector
     * 
     * @param string $role   The name of the role you wnat to select.
     * 
     * @return Imperium
     */
     
    function role($role=null)
    {
        $this->role = $role;
        
        return $this;
    }
    
    
    
    
    /**
     * Set the user
     * 
     * @param int $id   The id of the user.
     * 
     * @return Imperium
     */
    
    function caller($id)
    {
        $this->user = $id;
        
        return $this;
    }
    
    
    
    
    /**
     * Self selector
     * 
     * Remove all the selected organizations and the roles, 
     * now point to ourself directly.
     * 
     * @return Imperium
     */
     
    function self()
    {
        $this->org  = null;
        $this->role = null;
        
        return $this;
    }
    



    /***********************************************
    /***********************************************
    /************* R E S O U R C E S ***************
    /***********************************************
    /***********************************************
    
    /**
     * Specify the organization of the resources
     * 
     * @param string $org   The name of the organization you want to sepcify.
     * 
     * @return Imperium
     */
     
    function resOrg($org)
    {
        $this->resOrg = $org;
        
        return $this;
    }
    
    
    
    
    /**
     * Specify the role of the resources
     * 
     * @param string $role   The name of the role you want to sepcify.
     * 
     * @return Imperium
     */
     
    function resRole($role)
    {
        $this->resRole = $role;
        
        return $this;
    } 
    
    
    
    
    /**
     * Specify the type of the resources
     * 
     * @param string $org   The name of the type you want to specify.
     * 
     * @return Imperium
     */
     
    function resType($type)
    {
        $this->resType = $type;
        
        return $this;
    }
    
    
    
    
    /**
     * Sepcify the identifier of the resources
     * 
     * @param string $id   The identifier you want to specify.
     * 
     * @return Imperium
     */
     
    function resId($id)
    {
        $this->resId = $id;
        
        return $this;
    }
    
    
    
    
    /**
     * Save the specified data
     * 
     * @return array
     */
     
    function resSave()
    {
        return ['resOrg'  => $this->resOrg,
                'resRole' => $this->resRole,
                'resType' => $this->resType,
                'resId'   => $this->resId];
    }
    
    
    
    
    /**
     * Load the specified data
     * 
     * @param array $savedData   The data which saved by the resSave().
     * 
     * @return Imperium
     */
     
    function resLoad($savedData)
    {
        $this->resOrg  = $savedData['resOrg'];
        $this->resRole = $savedData['resRole'];
        $this->resType = $savedData['resType'];
        $this->resId   = $savedData['resId'];
        
        return $this;
    }
    
    
    
    
    /**
     * Clean the selectors of the resources
     * 
     * @return Imperium
     */
     
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
    /************ P E R M I S S I O N **************
    /***********************************************
    /***********************************************
    
    /**
     * Allow a permission
     * 
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     * 
     * @return Imperium
     */
     

    function allow($actions, $resType=null, $resId=null)
    {
        if($resType)
            $this->resType = $resType;
        if($resId)
            $this->resId   = $resId;
        
        $actions = $this->analyzeActions($actions);
        
        return $this->processPermission(true, $actions);
    }
    
    
    
    
    /**
     * Deny a permission
     * 
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     * 
     * @return Imperium
     */
     
    function deny($actions, $resType=null, $resId=null)
    {
        if($resType)
            $this->resType = $resType;
        if($resId)
            $this->resId   = $resId;
            
        $actions = $this->analyzeActions($actions);
            
        return $this->processPermission(false, $actions);
    }
    
    
    
    
    /**
     * Process a permission
     * 
     * Add a single or multiple permissions to the allowed or denied list.
     * 
     * @param bool         $allow     Set true if this is a positive permission or false when it's a negative permission.
     * @param array|string $actions   The name of the actions.
     * 
     * @return Imperium
     */
    
    function processPermission($allow=true, $actions)
    {
        if(!$this->hasInitializedPermission)
            $this->initializePermission();
        
        $grant = $allow ? 'allow' : 'deny';
        
        foreach((array)$actions as $action)
        {
            $position = &$this->getPermissionPosition();

            $position[$grant][$action][$this->resType][] = $this->generateResource();
        }
        
        
        $this->self();
        $this->cleanRes();
        
        return $this;   
    }
    
    
    
    
    /**
     * Generate an array of the current specify resource
     * 
     * @return array
     */
     
    function generateResource()
    {
        return ['org'  => $this->resOrg,
                'role' => $this->resRole,
                'id'   => $this->resId];
    }
    
    
    
    
    /**
     * Get permission position
     * 
     * Return the right permission array by the current pointer of the organization, role or the user.
     * 
     * @return array
     */
    
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
    
    
    
    
    /**
     * Initialize the permission
     * 
     * @return Imperium
     */
    
    function initializePermission()
    {
        $permission = ['allow' => [], 
                       'deny'  => []];
        
        $position = &$this->getPermissionPosition();
        $position = &$permission;
        
        return $this;
    }
    
    
    
    
    /**
     * Has the current permission position initialized?
     * 
     * @return bool
     */
     
    function hasInitializedPermission()
    {
        $position = $this->getPermissionPosition();
        
        return isset($position);
    }
    
    
    
    
    /**
     * Detect the type of the permission
     * 
     * Detected by the pointers.
     * 
     * @return string
     */
     
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
    
    
    
    
    /**
     * Detect the type of the resource
     * 
     * @return string
     */
    
    function detectResource()
    {
        if    ($this->resOrg  == '%' && $this->resRole == '%' && $this->resId == '%' && $this->resType == '%')
            return 'any';
        elseif($this->resOrg  != '%' && $this->resRole != '%' && $this->resId != '%')
            return 'all';
        elseif($this->resOrg  != '%' && $this->resRole != '%' && $this->resId == '%')
            return 'orgRole';
        elseif($this->resOrg  != '%' && $this->resRole == '%' && $this->resId != '%')
            return 'orgId';
        elseif($this->resOrg  == '%' && $this->resRole != '%' && $this->resId != '%')
            return 'roleId';
        elseif($this->resOrg  != '%')
            return 'org';
        elseif($this->resRole != '%')
            return 'role';
        elseif($this->resId   != '%')
            return 'id';
    }
    
    
    
    
    /**
     * Return all allowed permissions
     * 
     * @return array
     */
    
    function allowed()
    {
        
    }




    /**
     * Return all denied permissions
     * 
     * @return array
     */
     
    function denied()
    {
        
    }
    
    
    
    
    /**
     * Get a list which has allowed and denied permissions in it
     * 
     * @param bool $allowedOnly   Set true if you want to get a allowed permissions list only.
     * 
     * @return array
     */
     
    function permissionList($allowedOnly=false)
    {
        if(!$this->user) return false;
        
        //remove allow if in deny list have one
        $list = ['allow' => [],
                 'deny'  => []];
        
        //inherit support
        foreach((array)$this->users[$this->user] as $org => $roles)
        {
            foreach((array)$roles as $role)
            {
                
                $permissions = $this->permissions['orgs'][$org]['roles'][$role]['permissions'];
                
                if(!isset($permissions))
                    continue;
                
                $list        = array_merge_recursive($list, (array)$permissions);
            }
            
            $permissions = $this->permissions['orgs'][$org]['permissions'];
            $list        = array_merge_recursive($list, (array)$permissions);
        }
        
        $permissions = $this->permissions['users'][$this->user]['permissions'];
        $list        = array_merge_recursive($list, (array)$permissions);
        

        
        return $list;
                
    }
    
    
    
    
    /**
     * Search the permission list
     * 
     * @param bool   $inAllowedList   Set true if you want to search in the allowed list or denied list when falsed.
     * @param string $action          The name if the action.
     * 
     * @return bool
     */
     
    function searchPermission($inAllowedList=true, $action=null)
    {
        //TODO: 增進效能
        $position = $this->permissionList(true);

        $position = $inAllowedList ? $position['allow'] : $position['deny'];

       
        $has = false;
        
        foreach([$position[$action], $position['%']] as $action)
        {
            
            foreach((array)$action as $resType => $resources)
            {
                foreach($resources as $resource)
                {
                    //|| $this->resType == '%'
                    if($resType == $this->resType || $resType == '%' )
                    {

                        switch($this->detectResource())
                        {
                            case 'any':
                                $has = true;
                                break;
                                
                            case 'all':
                            case NULL :
                                if(($resource['org']   == $this->resOrg  && $resource['role'] == $this->resRole && $resource['id'] == $this->resId) ||
                                   ($resource['org']   == '%'            && $resource['role'] == '%'            && $resource['id'] == '%'))
                                   $has = true;
                                break;
                                
                            case 'orgRole':
                                if(($resource['org']  == $this->resOrg  && $resource['role'] == $this->resRole) ||
                                   ($resource['org']  == '%'            && $resource['role'] == '%'))
                                   $has = true;
                                break;
                                
                            case 'orgId':
                                if(($resource['org']  == $this->resOrg  && $resource['id']   == $this->resId) ||
                                   ($resource['org']  == '%'            && $resource['id']   == '%'))
                                   $has = true;
                                break;
                                
                            case 'roleId':
                                if(($resource['role'] == $this->resRole && $resource['id']   == $this->resId) ||
                                   ($resource['role'] == '%'            && $resource['id']   == '%'))
                                   $has = true;
                                break;
                                
                            case 'org':
                                if($resource['org']  == $this->resOrg  || $resource['org']  == '%')
                                   $has = true;
                                break;
                                
                            case 'role':
                                if($resource['role'] == $this->resRole || $resource['role'] == '%')
                                   $has = true;
                                break;
                                
                            case 'id':
                                if($resource['id']   == $this->resId   || $resource['id']   == '%')
                                   $has = true;
                                break;

                        }
                    }
                }
            }
        }       
        
                        //if(($resType == $this->resType || $resType == '%') && ($resource === $condition))
                            //$has = true;

        return $has;
    }
    



    /***********************************************
    /***********************************************
    /************ C A N & C A N N O T **************
    /***********************************************
    /***********************************************

    /**
     * Can do something?
     * 
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     * 
     * @return bool
     */
    
    function can($actions, $resType=null, $resId=null)
    {
        if($resType)
            $this->resType = $resType;
        if($resId)
            $this->resId   = $resId;
            
        $can = true;
        
        $actions = $this->analyzeActions($actions);
        
        if($this->cannot($actions, $resType, $resId))
            return false;
        
        
        /** If $can is false, just keep it as false */
        foreach($actions as $action)
            $can = $can ? $this->searchPermission(true, $action) : false;
        
        return $can;
    }
    
    
    
    
    /**
     * Cannot do something?
     *
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     * 
     * @return bool
     */
    
    function cannot($actions, $resType=null, $resId=null)
    {
        if($resType)
            $this->resType = $resType;
        if($resId)
            $this->resId   = $resId;
            
        $cannot = true;
        
        $actions = $this->analyzeActions($actions);
        
        foreach($actions as $action)
        {
            $isAllowed = $this->searchPermission(true, $action);
            $isDenied  = $this->searchPermission(false, $action);
            
            $cannot = $cannot ? !(!$isDenied && $isAllowed) : true;
        }    

        return $cannot;
    }
    
    
    

    /***********************************************
    /***********************************************
    /************ U S E R   H E L P E R ************
    /***********************************************
    /***********************************************
     
    /**
     * Has the user initialized?
     * 
     * @param int $id   The identifier of the user.
     * 
     * @return bool
     */
    
    function hasInitializedUser($id)
    {
        return isset($this->users[$this->user]);
    }
    
    
    
    
    /**
     * Initialize a user
     * 
     * @param int $id   The identifier of the user.
     * 
     * @return Imperium
     */
     
    function initializeUser($id)
    {  
        $this->users[$this->user]['orgs']        = [];
        $this->users[$this->user]['permissions'] = [];
        
        return $this;
    }
    
    


    /***********************************************
    /***********************************************
    /****************** A L I A S ******************
    /***********************************************
    /***********************************************

    /**
     * Add an alias
     * 
     * @param string $name      The name of the alias.
     * @param array  $actions   The actions of the alias.
     * 
     * @return Imperium
     */
    
    function alias($name, $actions)
    {
        $this->alias[$name] = $actions;
        
        return $this;
    }
    
    
    
    
    /**
     * Analyze the actions and convert the alias to the actions.
     * 
     * @param array|string $actions   The actions which may include some aliases.
     * 
     * @return array                  The array which has actions only and no any aliases.
     */
    
    function analyzeActions($actions)
    {
        $list = [];
        
        foreach((array)$actions as $action)
        {
            /** Analyze this action because it's an alias */
            if(isset($this->alias[$action]))
                foreach((array)$this->alias[$action] as $aliasAction)
                    array_push($list, $aliasAction);
                
            /** Push the action to the array if it's not an alias */
            else
                array_push($list, $action);
            
        }
        
        return $list;
    }
    
    
    
    /***********************************************
    /***********************************************
    /***************** H E L P E R *****************
    /***********************************************
    /***********************************************
    
    /**
     * Assign a single or multiple roles
     * 
     * @param array|string $roles   The name of the roles.
     * 
     * @return Imperium
     */
     
    function assign($roles)
    {
        $org = &$this->users[$this->user][$this->org];
        
        if(!isset($org))
            $org = [];
        
        foreach((array)$roles as $role)
            array_push($org, $role);
        
        return $this;
    }
}
?>