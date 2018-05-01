<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use Session;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax()) {
            $authors = Author::all();

            return Datatables::of($authors)
                ->addColumn('action', function ($author) {
                    return view ('datatable._action', [
                        'edit_url' => route('authors.edit', $author->id),
                        'delete_url' => route('authors.destroy', $author->id),
                        'confirm_message' => 'Yakin mau menghapus ' . $author->name . '?'
                    ]);
                })->toJson();
        }

        $html = $htmlBuilder
        ->columns([
            ['data' => 'name', 'name' => 'name', 'title' => 'Nama'],
            ['data' => 'action', 'name' => 'action', 'title' => '', 'orderable' => false, 'searchable' =>false ]
        ]);

        return view('authors.index', compact('html'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:authors'
        ],
        [
            'name.required' => 'Harus Di Isi Gak Boleh Kosong',
            'name.unique' => 'Nama tersebut Sudah Ada Di Daftar, Cobalah nama Lain'
        ]);

        $authors = Author::create($request->all());

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menyimpan " . "<strong>$authors->name</strong",
        ]);

        return redirect()->route('authors.index');

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
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Author $author)
    {
        $request->validate([
            'name' => 'required|unique:authors,name,'. $author->id
        ],
        [
            'name.required' => 'Harus Di Isi Gak Boleh Kosong', 
            'name.unique' => 'Nama Tersebut Sudah Ada Di Daftar, Cobalah nama Lain'
        ]);

        $author->update($request->only('name'));

        Session::flash("flash_notification", [
            "level" => "success",
            "message" => "Berhasil Menyimpan $author->name",
        ]);

        return redirect()->route('authors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if (!$author->delete()) {
            return redirect()->back();
        }

        Session::flash("flash_notification", [
            "level" => "danger",
            "message"   => "Penulis Berhasil Di Hapus <strong>$author->name</strong>"
        ]);

        return redirect()->route('authors.index');
    }
}
