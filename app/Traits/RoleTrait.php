<?php
namespace App\Traits;

use App\Models\User;
use App\Models\Role;


trait RoleTrait
{
    public function RolePermision($user, $role)
    {
       $hasRole =  Role::Where(['user_id'=>$user,'role'=>$role])->first();
       if($hasRole){
           return TRUE;
       }
    }
	public function hasPermision($user, $roles)
    {
		$hasRights=false;
		foreach($roles as $role) {
			$hasRole =  Role::Where(['user_id'=>$user,'role'=>$role])->first();
		   if($hasRole) {
			   $hasRights =  TRUE;
			}
			if($hasRights) {
			 return TRUE;	
			}
		}       
    }
}
?>