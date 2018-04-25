<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Author extends Model
{
    protected $fillable = ['name'];

    public function books() 
    {
        return $this->hasMany('App\Book');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function($author) {
            // mengecek apakah penulis amsih memiliki buku 
            if ($author->books->count() > 0) {
                // menyiapkan pesan error
                $html = 'Penulis Tidak Bisa Di Hapus Karena Masih Memiliki Buku : ';
                $html .= '<ul>';
                    foreach($author->books as $book) {
                        $html .= "<li>$book->title</li>";
                    }
                $html .= '</ul>';

                Session::flash("flash_notification", [
                    "level" => "danger",
                    "message" => $html
                ]);

                // membatalkan proses penghapusan
                return false;
            }
        });
    } 
}
