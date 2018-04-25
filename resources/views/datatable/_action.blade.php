<form action="{{ $delete_url }}" method="POST" class="float-right" >
    @csrf
    @method('DELETE')

    <a href="{{ $edit_url }}" class="btn btn-primary">Ubah</a>
    <button class="btn btn-danger" type="submit">Hapus</button>
</form>

{{-- <a href="{{ $delete_url }}" class="btn btn-danger">Delete</a> --}}