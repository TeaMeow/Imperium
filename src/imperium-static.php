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

//if(session_status() == PHP_SESSION_NONE)
//    session_start();

class Imperium
{
    /**
     * Organization pointer
     *
     * @var null|string
     */

    private static $org            = null;

    /**
     * Role pointer
     *
     * @var null|string
     */

    private static $role           = null;

    /**
     * User pointer
     *
     * @var null|string
     */

    private static $user           = null;

    /**
     * Organization pointer of the resource
     *
     * @var string
     */

    private static $resOrg         = '%';

    /**
     * Role pointer of the resource
     *
     * @var string
     */

    private static $resRole        = '%';

    /**
     * Type pointer of the resource
     *
     * @var string
     */

    private static $resType        = '%';

    /**
     * Identifier pointer of the resource
     *
     * @var string
     */

    private static $resId          = '%';

    /**
     * Stores the aliases
     *
     * @var array
     */

    private static $alias          = [];

    /**
     * Stores the organizations
     *
     * @var array
     */

    public  static $orgs           = [];

    /**
     * Stores the roles of the organizations
     *
     * @var array
     */

    public  static $roles          = [];

    /**
     * Stores the users and which organizations they belong
     *
     * @var array
     */

    public  static $users          = [];

    /**
     * Stores the permissions of the organizations and the users
     *
     * @var array
     */

    public  static $permissions     = [
                                       'orgs'  => [],
                                       'roles' => [],
                                       'users' => []
                                      ];

    /**
     * Used to check if the current user is a guest or not.
     *
     * @var bool
     */

    public static $isGuest         = true;

    /**
     * Relax check toggle, for can() and cannot(), when this is true,
     * we return true if one of the actions in can() is actually can or in cannot() is actually can't.
     *
     * @var bool
     */

    private static $relax           = false;




    /**
     * Add a single organization
     *
     * @param string $org      The name of the organization.
     * @param string $parent   The parent organization of the organization.
     *
     * @return Imperium
     */

    static function addOrg($org, $parent=null)
    {
        /** Add the org in the org array */
        self::$orgs[$org] = ['parent' => $parent];

        /** Add the org in the permission array */
        self::$permissions['orgs'][$org] = [
                                            'roles'       => [],
                                            'permissions' => []
                                           ];

        return __CLASS__;
    }




    /**
     * Add roles
     *
     * @param array|string $roles     The names of the roles.
     * @param string       $inherit   The name of the role which the roles should inherit from.
     *
     * @return Imperium
     */

    static function addRole($roles, $inherit=null)
    {
        foreach((array)$roles as $singleRole)
            self::$roles[self::$org][$role] = ['inherit' => $inherit];

        return __CLASS__;
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

    static function org($org=null)
    {
        self::$org = $org;

        return __CLASS__;
    }




    /**
     * Role selector
     *
     * @param string $role   The name of the role you wnat to select.
     *
     * @return Imperium
     */

    static function role($role=null)
    {
        self::$role = $role;

        return __CLASS__;
    }




    /**
     * Set the user
     *
     * @param int $id   The id of the user.
     *
     * @return Imperium
     */

    static function caller($id)
    {
        self::$user     = $id;
        self::$isGuest  = false;

        /** Reset the user if false or null */
        if($id === false || $id === null)
        {
            self::$user     = null;
            self::$isGuest  = true;

            return __CLASS__;
        }

        return __CLASS__;
    }




    /**
     * Self selector
     *
     * Remove all the selected organizations and the roles,
     * now point to ourself directly.
     *
     * @return Imperium
     */

    static function self()
    {
        self::$org  = null;
        self::$role = null;

        return __CLASS__;
    }




    /**
     * User selector
     *
     * @return Imperirum
     */

    static function user()
    {

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

    static function resOrg($org)
    {
        self::$resOrg = $org;

        if(!$org)
            self::$resOrg = '%';

        return __CLASS__;
    }




    /**
     * Specify the role of the resources
     *
     * @param string $role   The name of the role you want to sepcify.
     *
     * @return Imperium
     */

    static function resRole($role)
    {
        self::$resRole = $role;

        if(!$role)
            self::$resRole = '%';

        return __CLASS__;
    }




    /**
     * Specify the type of the resources
     *
     * @param string $org   The name of the type you want to specify.
     *
     * @return Imperium
     */

    static function resType($type)
    {
        self::$resType = $type;

        if(!$type)
            self::$resType = '%';

        return __CLASS__;
    }




    /**
     * Sepcify the identifier of the resources
     *
     * @param string $id   The identifier you want to specify.
     *
     * @return Imperium
     */

    static function resId($id)
    {
        self::$resId = $id;

        if(!$id)
            self::$resId = '%';

        return __CLASS__;
    }




    /**
     * Save the specified data
     *
     * @return array
     */

    static function resSave()
    {
        return ['resOrg'  => self::$resOrg,
                'resRole' => self::$resRole,
                'resType' => self::$resType,
                'resId'   => self::$resId];
    }




    /**
     * Load the specified data
     *
     * @param array $savedData   The data which saved by the resSave().
     *
     * @return Imperium
     */

    static function resLoad($savedData)
    {
        self::$resOrg  = $savedData['resOrg'];
        self::$resRole = $savedData['resRole'];
        self::$resType = $savedData['resType'];
        self::$resId   = $savedData['resId'];

        return __CLASS__;
    }




    /**
     * Clean the selectors of the resources
     *
     * @return Imperium
     */

    static function cleanRes()
    {
        self::$resOrg  = '%';
        self::$resRole = '%';
        self::$resType = '%';
        self::$resId   = '%';

        return __CLASS__;
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


    static function allow($actions, $resType=null, $resId=null)
    {
        if($resType)
            self::$resType = $resType;
        if($resId)
            self::$resId   = $resId;

        $actions = self::analyzeActions($actions);

        return self::processPermission(true, $actions);
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

    static function deny($actions, $resType=null, $resId=null)
    {
        if($resType)
            self::$resType = $resType;
        if($resId)
            self::$resId   = $resId;

        $actions = self::analyzeActions($actions);

        return self::processPermission(false, $actions);
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

    static function processPermission($allow=true, $actions)
    {
        if(!self::hasInitializedPermission)
            self::initializePermission();

        $grant = $allow ? 'allow' : 'deny';

        foreach((array)$actions as $action)
        {
            $position = &self::getPermissionPosition();

            foreach((array)self::$resType as $resType)
                $position[$grant][$action][$resType][] = self::generateResource();
        }


        self::self();
        self::cleanRes();

        return __CLASS__;
    }




    /**
     * Generate an array of the current specify resource
     *
     * @return array
     */

    static function generateResource()
    {
        return ['org'  => self::$resOrg,
                'role' => self::$resRole,
                'id'   => self::$resId];
    }




    /**
     * Get permission position
     *
     * Return the right permission array by the current pointer of the organization, role or the user.
     *
     * @return array
     */

    static function &getPermissionPosition()
    {
        switch(self::detectPermission())
        {
            case 'org':
                return self::$permissions['orgs'][self::$org]['permissions'];
                break;

            case 'orgRole':
                return self::$permissions['orgs'][self::$org]['roles'][self::$role]['permissions'];
                break;

            case 'user':
                return self::$permissions['users'][self::$user]['permissions'];
                break;
        }
    }




    /**
     * Initialize the permission
     *
     * @return Imperium
     */

    static function initializePermission()
    {
        $permission = ['allow' => [],
                       'deny'  => []];

        $position = &self::getPermissionPosition();
        $position = &$permission;

        return __CLASS__;
    }




    /**
     * Has the current permission position initialized?
     *
     * @return bool
     */

    static function hasInitializedPermission()
    {
        $position = self::getPermissionPosition();

        return isset($position);
    }




    /**
     * Detect the type of the permission
     *
     * Detected by the pointers.
     *
     * @return string
     */

    static function detectPermission()
    {
        if(self::$org && !self::$role)
            return 'org';
        elseif(self::$org && self::$role)
            return 'orgRole';
        elseif(!self::$org && self::$role)
            return 'role';
        elseif(!self::$org && !self::$role && !self::$isGuest)
            return 'user';
        else
            return 'guest';
    }




    /**
     * Detect the type of the resource
     *
     * @return string
     */

    static function detectResource()
    {
        if    (self::$resOrg  == '%' && self::$resRole == '%' && self::$resId == '%' && self::$resType == '%')
            return 'any';
        elseif(self::$resOrg  != '%' && self::$resRole != '%' && self::$resId != '%')
            return 'all';
        elseif(self::$resOrg  != '%' && self::$resRole != '%' && self::$resId == '%')
            return 'orgRole';
        elseif(self::$resOrg  != '%' && self::$resRole == '%' && self::$resId != '%')
            return 'orgId';
        elseif(self::$resOrg  == '%' && self::$resRole != '%' && self::$resId != '%')
            return 'roleId';
        elseif(self::$resOrg  != '%')
            return 'org';
        elseif(self::$resRole != '%')
            return 'role';
        elseif(self::$resId   != '%')
            return 'id';
    }




    /**
     * Return all allowed permissions
     *
     * @return array
     */

    static function allowed()
    {

    }




    /**
     * Return all denied permissions
     *
     * @return array
     */

    static function denied()
    {

    }




    /**
     * Get a list which has allowed and denied permissions in it
     *
     * @param bool $allowedOnly   Set true if you want to get a allowed permissions list only.
     *
     * @return array
     */

    static function permissionList($allowedOnly=false)
    {
        if(!self::$user) return false;

        //remove allow if in deny list have one
        $list = ['allow' => [],
                 'deny'  => []];

        //inherit support
        foreach((array)self::$users[self::$user] as $org => $roles)
        {
            foreach((array)$roles as $role)
            {

                $permissions = self::$permissions['orgs'][$org]['roles'][$role]['permissions'];

                if(!isset($permissions))
                    continue;

                $list        = array_merge_recursive($list, (array)$permissions);
            }

            $permissions = self::$permissions['orgs'][$org]['permissions'];
            $list        = array_merge_recursive($list, (array)$permissions);
        }

        $permissions = self::$permissions['users'][self::$user]['permissions'];
        $list        = array_merge_recursive($list, (array)$permissions);



        return $list;

    }




    /**
     * Search the permission list
     *
     * @param bool         $inAllowedList     Set true if you want to search in the allowed list or denied list when falsed.
     * @param string       $action            The name if the action.
     * @param array|string $pointingResType   The type(s) of the resources.
     *
     * @return bool
     */

    static function searchPermission($inAllowedList=true, $action=null, $pointingResType=null)
    {
        $pointingResType = $pointingResType ?: self::$resType;

        //TODO: 增進效能
        $position = self::permissionList(true);

        $position = $inAllowedList ? $position['allow'] : $position['deny'];


        $has = false;

        foreach([$position[$action], $position['%']] as $action)
        {

            foreach((array)$action as $resType => $resources)
            {
                foreach($resources as $resource)
                {
                    //|| self::$resType == '%'
                    if($resType == $pointingResType || $resType == '%' )
                    {

                        switch(self::detectResource())
                        {
                            case 'any':
                                $has = true;
                                break;

                            case 'all':
                            case NULL :
                                if(($resource['org']   == self::$resOrg  && $resource['role'] == self::$resRole && $resource['id'] == self::$resId) ||
                                   ($resource['org']   == '%'            && $resource['role'] == '%'            && $resource['id'] == '%'))
                                   $has = true;
                                break;

                            case 'orgRole':
                                if(($resource['org']  == self::$resOrg  && $resource['role'] == self::$resRole) ||
                                   ($resource['org']  == '%'            && $resource['role'] == '%'))
                                   $has = true;
                                break;

                            case 'orgId':
                                if(($resource['org']  == self::$resOrg  && $resource['id']   == self::$resId) ||
                                   ($resource['org']  == '%'            && $resource['id']   == '%'))
                                   $has = true;
                                break;

                            case 'roleId':
                                if(($resource['role'] == self::$resRole && $resource['id']   == self::$resId) ||
                                   ($resource['role'] == '%'            && $resource['id']   == '%'))
                                   $has = true;
                                break;

                            case 'org':
                                if($resource['org']  == self::$resOrg  || $resource['org']  == '%')
                                   $has = true;
                                break;

                            case 'role':
                                if($resource['role'] == self::$resRole || $resource['role'] == '%')
                                   $has = true;
                                break;

                            case 'id':
                                if($resource['id']   == self::$resId   || $resource['id']   == '%')
                                   $has = true;
                                break;

                        }
                    }
                }
            }
        }

                        //if(($resType == self::$resType || $resType == '%') && ($resource === $condition))
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

    static function can($actions, $resType=null, $resId=null)
    {
        if($resType)
            self::$resType = $resType;
        if($resId)
            self::$resId   = $resId;

        $can = true;

        $actions = self::analyzeActions($actions);

        if(self::cannot($actions, $resType, $resId))
            return false;


        foreach($actions as $action)
        {
            foreach((array)self::$resType as $resType)
            {
                if(self::$relax)
                {
                    /** Stop if can, because it's relax mode */
                    $can = self::searchPermission(true, $action, $resType);

                    if($can) break;
                }
                else
                {
                    /** If $can is false, just keep it as false till the end */
                    $can = $can ? self::searchPermission(true, $action, $resType) : false;
                }
            }
        }

        self::$relax = false;

        return $can;
    }




    /**
     * Can do one of the things?
     *
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     *
     * @return bool
     */

    static function canAny($actions, $resType=null, $resId=null)
    {
        self::$relax = true;

        return self::can($actions, $resType, $resId);
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

    static function cannot($actions, $resType=null, $resId=null)
    {
        if($resType)
            self::$resType = $resType;
        if($resId)
            self::$resId   = $resId;

        $cannot = true;

        $actions = self::analyzeActions($actions);

        foreach($actions as $action)
        {
            foreach((array)self::$resType as $resType)
            {

                $isAllowed = self::searchPermission(true, $action, $resType);
                $isDenied  = self::searchPermission(false, $action, $resType);

                if(self::$relax)
                {
                    $cannot = ($isDenied || !$isAllowed);

                    if($cannot) break;
                }
                else
                {
                    $cannot = $cannot ? ($isDenied || !$isAllowed) : false;
                }
            }
        }

        self::$relax = false;

        return $cannot;
    }




    /**
     * Cannot do one of the things?
     *
     * @param array|string $actions   The name of the actions.
     * @param null|string  $resType   The type of the resources.
     * @param null|int     $resId     The identifier of the resources.
     *
     * @return bool
     */

    static function cannotAny($actions, $resType=null, $resId=null)
    {
        self::$relax = true;

        return self::cannot($actions, $resType, $resId);
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

    static function hasInitializedUser($id)
    {
        return isset(self::$users[self::$user]);
    }




    /**
     * Initialize a user
     *
     * @param int $id   The identifier of the user.
     *
     * @return Imperium
     */

    static function initializeUser($id)
    {
        self::$users[self::$user]['orgs']        = [];
        self::$users[self::$user]['permissions'] = [];

        return __CLASS__;
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

    static function alias($name, $actions)
    {
        self::$alias[$name] = $actions;

        return __CLASS__;
    }




    /**
     * Analyze the actions and convert the alias to the actions.
     *
     * @param array|string $actions   The actions which may include some aliases.
     *
     * @return array                  The array which has actions only and no any aliases.
     */

    static function analyzeActions($actions)
    {
        $list = [];

        foreach((array)$actions as $action)
        {
            /** Analyze this action because it's an alias */
            if(isset(self::$alias[$action]))
                foreach((array)self::$alias[$action] as $aliasAction)
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

    static function assign($roles)
    {
        $org = &self::$users[self::$user][self::$org];

        if(!isset($org))
            $org = [];

        foreach((array)$roles as $role)
            array_push($org, $role);

        return __CLASS__;
    }
}
?>