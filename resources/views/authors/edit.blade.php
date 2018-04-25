@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('authors.index') }}">Penulis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Penulis</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Tambah Penulis</div>

                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('authors.update', $author->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama Penulis</label>
                            <div class="col-sm-4">
                            <input name="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ $author->name }}">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
