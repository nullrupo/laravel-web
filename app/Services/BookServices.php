<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\BookRepository;
use App\Repositories\BaseRepository;
use App\Models\Book;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use Illuminate\Support\Arr;

class BookService
{
    protected $service = 'Book';

    public function __construct(BookRepository $book, BaseRepository $base)
    {
        $this->base = $base;
        $this->book = $book;

        $this->middleware('permission:book-list|book-create|book-edit|book-delete', ['only' => ['index','show']]);
        $this->middleware('permission:book-create', ['only' => ['create','store']]);
        $this->middleware('permission:book-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:book-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request, $service)
    {
        $this->service = $service;
        $book = $this->base->index();
    }


    public function store(Request $request, $service)
    {
        $this->service = $service;
        $this->base->validation($request, $service);

        $book = $this->base->input($request, $service);
    }


    public function update(Request $request, Book $book)
    {
        $this->service = $service;
        $this->base->validation($request, $service);

        $book->update($request->all());
    }

    public function delete(Book $book)
    {
        $book->delete();
    }
}