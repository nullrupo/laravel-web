<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Repositories\BaseRepository;

class BaseService
{
    public function __construct(BaseRepository $base)
    {
        $this->base = $base;
    }

    public function index(Request $request, $service)
    {
        return $service::orderBy('id','DESC')->paginate(5);
    }

    public function get($service, $id)
    {
        return $service::find($id);
    }

    public function getPermission()
    {
        return Permission::get();
    }

    public function validation(Request $request, $service)
    {
        if($service = 'User') {
            return $request->validate([
                'name'      => 'required',
                'email'     => 'required|email|unique:users,email',
                'password'  => 'required|same:confirm-password',
                'roles'     => 'required'
            ]);
        }
        elseif($service = 'Book'){
            return $request->validate([
                'name'         => 'required',
                'author'       => 'required',
                'publish_date' => 'required',
                'import_price' => 'required',
                'sale_price'   => 'required',
                'status'       => 'required',
            ]);
        }
        elseif($service = 'Role'){
            return $request->validate([
                'name'       => 'required|unique:roles,name',
                'permission' => 'required',
            ]);
        }
    }
    

    public function input(Request $request, $service)
    {
        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }
        return $service::create($input);
    }


    public function sync(Request $request)
    {
        return syncPermissions($request->input('permission'));
    }

}