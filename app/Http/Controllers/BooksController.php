<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Author;
use Session;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax()) {
            $books = Book::with('author');
            
            return Datatables::of($books)
                ->addColumn('action', function ($book) {
                    return view ('datatable._action', [
                        'model' => $book,
                        'delete_url'  => route('books.destroy', $book->id),
                        'edit_url'  => route('books.edit', $book->id),
                        'confirm_message'   => "Yakin Mau Menghapus" . $book->title,
                    ]);
                })->toJson();
        }

        $html = $htmlBuilder
        ->columns([
            ['data' => 'title', 'name' => 'title', 'title' => 'Judul', 'orderable' => false],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Jumlah', 'orderable' => false],
            ['data' => 'author.name', 'name' => 'author.name', 'title' => 'Penulis', 'orderable' => false, 'searchable' =>false],
            ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' =>false ]
        ]);

        return view('books.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authors = Author::all();

        return view('books.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:books,title',
            'author_id' => 'required|exists:authors,id',
            'amount'  => 'required|numeric',
            'cover' => 'image|max:2048'
        ]);

        $book = Book::create($request->except('cover'));

        // isi field cover jika ada cover yang diupload
        if ($request->hasFile('cover')) {
            // Mengambil file yang diupload
            $uploaded_cover = $request->file('cover');
            
            // mengambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();
            
            // membuat nama file random berikut extension
            $filename = md5(time()) . '.' . $extension;
            
            // menyimpan cover ke folder public/img
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);
            
            // mengisi field cover di book dengan filename yang baru dibuat
            $book->cover = $filename;
            $book->save();
        }

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menyimpan $book->title",
        ]);

        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $authors = Author::all();

        return view('books.edit', compact('book', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
