<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\BaseRepository;
use App\Repositories\RoleRepository;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserServices
{
    protected $service = 'User';

    public function __construct(UserRepository $user, BaseRepository $base, RoleRepository $role)
    {
        $this->base = $base;
        $this->user = $user;
        $this->role = $role;

        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request, $service)
    {
        $this->service = $service;
        $data = $this->base->index();
    }


    public function create()
    {
        $permission = $this->base->getPermission();
        $roles = $this->role->getRole();
    }


    public function store(Request $request, $service)
    {
        $this->service = $service;
        $this->base->validation($request, $service);

        $user = $this->base->input($request, $service);
        $user->assignRole($request->input('roles'));
    }


    public function show($id, $service)
    {
        $this->service = $service;
        $user = $this->base->get($service, $id);
    }


    public function edit($id, $service)
    {
        $this->service = $service;
        $permission = $this->base->getPermission();

        $user = $this->base->get($service, $id);
        $roles = $this->role->getRole();
        $userRole = $user->roles->pluck('name','name')->all();
    }


    public function update(Request $request, $id)
    {
        $this->service = $service;
        $this->base->validation($request, $service);

        $user = $this->base->input($request, $service);
        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));
    }


    public function delete($id)
    {
        User::find($id)->delete();
    }
}