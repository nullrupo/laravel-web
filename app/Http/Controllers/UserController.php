<?php

namespace App\Http\Controllers;


use App\Services\UserServices;
use App\Services\BaseServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Repositories\UserRepository;
use App\Repositories\BaseRepository;

class UserController extends Controller
{
    protected $use;

    public function __construct(UserServices $use)
    {
        $this->use = $use;
    }


    public function index(Request $request, $service)
    {
        $this->use->index($request, $service);

        return view('users.index',compact('data'));
    }


    public function create()
    {
        $this->use->create();

        return view('users.create',compact('roles'));
    }


    public function store(Request $request, $service)
    {
        $this->use->store($request, $service);

        return redirect()->route('users.index')
                         ->with('success','User created successfully');
    }

    public function show($id, $service)
    {
        $this->use->show($id, $service);

        return view('users.show',compact('user'));
    }

    public function edit($id, $service)
    {
        $this->use->edit($id, $service);

        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->use->update($request, $id);

        return redirect()->route('users.index')
                         ->with('success','User updated successfully');
    }

    public function delete($id)
    {
        $this->use->delete($id);

        return redirect()->route('users.index')
                         ->with('success','User deleted successfully');
    }
}
