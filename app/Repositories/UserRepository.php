<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function index(Request $request, $service)
    {
        return $this->user->index($request, $service);
    }


    public function create()
    {
        return $this->user->create();
    }


    public function store(Request $request, $service)
    {
        return $this->user->store($request, $service);
    }


    public function show($id, $service)
    {
        return $this->user->show($id, $service);
    }


    public function edit($id, $service)
    {
        return $this->user->edit($id, $service);
    }


    public function update(Request $request, $id)
    {
        return $this->user->update($request, $id);
    }


    public function delete($id)
    {
        return $this->user->delete($id);
    }

}
