<?php
function arrayRecursiveDiff($aArray1, $aArray2) {
  $aReturn = array();

  foreach ($aArray1 as $mKey => $mValue) {
    if (array_key_exists($mKey, $aArray2)) {
      if (is_array($mValue)) {
        $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
        if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
      } else {
        if ($mValue != $aArray2[$mKey]) {
          $aReturn[$mKey] = $mValue;
        }
      }
    } else {
      $aReturn[$mKey] = $mValue;
    }
  }
  return $aReturn;
} 

 
    
$A = ['allow' => [
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
                       '檢視' => [
                                     '文章' => [
                                                   [
                                                       'org'  => '單身俱樂部',
                                                       'role' => '管理員',
                                                       'id'   => 3
                                                   ]
                                               ]
                                 ]
                   ]];


function search($list, $DeniedList=null)
{
    
}

$unconditional = ['org'  => '%',
                          'role' => '%',
                          'id'   => '%'];

$allowed = $A['allow'];
$denied  = $A['deny'];

$allowedClean = $A['allow'];

foreach($allowed as $action => $resTypes)
{
        
    foreach($resTypes as $resType => $resources)
    {

        foreach($resources as $resourceIndex => $resource)
        {
           
            foreach((array)$denied[$action][$resType] as $key => $deniedResource)
            {
                if($resource === $deniedResource)
                    unset($allowedClean[$action][$resType][$key]);
            }
  
        }
    }
}

exit(var_dump($allowedClean));

?>