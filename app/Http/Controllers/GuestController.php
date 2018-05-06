<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Book;
use Laratrust\LaratrustFacade as Laratrust;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
          $books = Book::with('author')->get();

          return DataTables::of($books)
              ->addColumn('action', function($book) {
                if (Laratrust::hasRole('admin')) {
                    return '';
                }

                return '<a class="btn btn-xs btn-primary" href="' . route('guest.books.borrow', $book->id) . '">Pinjam Buku</a>';
              })
              ->addColumn('stock', function ($book) {
                  return $book->stock;
              })
              ->toJson();
        }

        $html = $builder->columns([
          ['data' => 'title', 'name' => 'title', 'title' => 'Judul Buku'],
          ['data' => 'stock', 'name' => 'stock', 'title' => 'Jumlah Buku'],
          ['data' => 'author.name', 'name' => 'author.name', 'title' => 'Penulis'],
          ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false,
          'searchable' => false],
        ]);

        return view('guest.index', compact('html'));
    }
}
