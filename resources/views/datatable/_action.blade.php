<form action="{{ $delete_url }}" method="POST" class="float-right js-confirm" data-confirm="{{ $confirm_message }}">
    @csrf
    @method('DELETE')

    <a href="{{ $edit_url }}" class="btn btn-primary">Ubah</a>
    <button class="btn btn-danger" type="submit">Hapus</button>
</form>
