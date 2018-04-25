<?php

use Illuminate\Database\Seeder;
use App\Author;
use App\Book;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $author1 = Author::create(['name' => 'Ahmad Fauzan']);
        $author2 = Author::create(['name' => 'Budi']);
        $author3 = Author::create(['name' => 'Seena']);

        $book1 = Book::create([
            'title' => 'Sword Art Online',
            'amount' => 3,
            'author_id' => $author1->id
        ]);

        $book1 = Book::create([
            'title' => 'Bagaimana Mencari kawan Dan mempengaruhi Orang lain',
            'amount' => 2,
            'author_id' => $author2->id
        ]);

        $book1 = Book::create([
            'title' => 'One Piece',
            'amount' => 5,
            'author_id' => $author3->id
        ]);

        $book1 = Book::create([
            'title' => 'Naruto',
            'amount' => 1,
            'author_id' => $author3->id
        ]);
    }
}
