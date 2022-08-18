<?php
namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;
use App\Models\Book;

class BaseRepository
{
    protected $base;

    public function __construct(BaseRepository $base)
    {
        $this->base = $base;
    }


    public function index(Request $request, $service)
    {
        return $this->base->index($request, $service);
    }

    public function get($service, $id)
    {
        return $this->base->get($service, $id);
    }

    public function getPermission()
    {
        return $this->base->getPermission();
    }

    public function validation(Request $request, $service)
    {
        return $this->base->validation($request, $service);
    }
    

    public function input(Request $request, $service)
    {
        return $this->base->input($request, $service);
    }


    public function sync(Request $request)
    {
        return $this->base->sync($request);
    } 

}