<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()->orderBy('id', 'ASC')->get();
        $roles = Role::with(['permissions'])->get();
        $responses = collect();
        foreach ($roles as $role) {
            $permissionRole = collect($role->permissions)->pluck('name')->toArray();
            $result = [];
            $result['id'] = $role->id;
            $result['name'] = strtoupper($role->name);
            $resultPermission = collect();
            $condition = "";
            foreach ($permissions as $permission) {
                $exploadeName = explode('.', $permission->name);
                if ($exploadeName[0] != $group) {
                    $group = $exploadeName[0];
                }
                $permis = [];
//                $permis['name'] = $exploadeName[0];
//                $permis['permissionname'] = $exploadeName[1];
//                $permis['checked'] = in_array($permission->name, $permissionRole);
                $resultPermission->push($permis);
            }
            $result['permissions'] = $resultPermission;
            $responses->push($result);
        }
        return view('permission.permission')->with('roles', $responses);
    }
}
