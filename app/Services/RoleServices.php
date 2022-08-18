<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Repositories\BaseRepository;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;

class RoleService
{
    protected $service = 'Role';

    public function __construct(RoleRepository $role, BaseRepository $base)
    {
        $this->base = $base;
        $this->role = $role;

        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }


    public function getRole()
    {
        return Role::pluck('name','name')->all();
    }


    public function index(Request $request, $service)
    {
        $this->service = $service;
        $role = $this->base->index();
    }


    public function store(Request $request, $service)
    {
        $this->service = $service;
        $this->base->validation($request, $service);

        $role->base->sync($request);
    }


    public function show($id, $service)
    {
        $this->service = $service;
        $role = $this->base->get($service, $id);

        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                                        ->where("role_has_permissions.role_id",$id)
                                        ->get();
    }


    public function edit($id, $service)
    {
        $this->service = $service;
        $role = $this->base->get($service, $id);

        $permission = $this->base->getPermission();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
                                                            ->pluck('role_has_permissions.permission_id',
                                                                    'role_has_permissions.permission_id')
                                                            ->all();
    }

    public function update(Request $request, $id, $service)
    {
        $this->service = $service;
        $this->base->validation($request, $service);
        $role = $this->base->get($service, $id);
    
        $role->name = $request->input('name');
        $role->save();
        $role->base->sync($request);
    }

    public function delete(Book $book,$id)
    {
        DB::table("roles")->where('id',$id)->delete();
    }

}