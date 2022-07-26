@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Books Inventory</h2>
            </div>
            <div class="pull-right">
                @can('book-create')
                <a class="btn btn-success" href="{{ route('book.create') }}"> Create New Book Entry</a>
                @endcan
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th width="30px">No</th>
            <th width="60px">Name</th>
            <th width="70px">Author</th>
            <th width="120px">Publish Date</th>
            <th width="120px">Import Price</th>
            <th width="120px">Sale Price</th>
            <th width="50px">Status</th>
            <th width="140px">Action</th>
        </tr>
	    @foreach ($book as $book)
	    <tr>
	        <td>{{ $book->id }}</td>
	        <td>{{ $book->name }}</td>
	        <td>{{ $book->author }}</td>
            <td>{{ $book->publish_date }}</td>
	        <td>{{ $book->import_price }}</td>
	        <td>{{ $book->sale_price }}</td>
            <td>{{ $book->status }}</td>
	        <td>
                <form action="{{ route('book.destroy',$book->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('book.show',$book->id) }}">Show</a>
                    @can('book-edit')
                    <a class="btn btn-primary" href="{{ route('book.edit',$book->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('book-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>

@endsection
