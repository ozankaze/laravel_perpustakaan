<?php

use Illuminate\Database\Seeder;
use App\Author;
use App\Book;
use App\BorrowLog;
use App\User;

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

        $book2 = Book::create([
            'title' => 'Bagaimana Mencari kawan Dan mempengaruhi Orang lain',
            'amount' => 2,
            'author_id' => $author2->id
        ]);

        $book3 = Book::create([
            'title' => 'One Piece',
            'amount' => 5,
            'author_id' => $author3->id
        ]);

        $book4 = Book::create([
            'title' => 'Naruto',
            'amount' => 1,
            'author_id' => $author3->id
        ]);

        // Sample peminjaman buku
        $member = User::where('email', 'member@main.com')->first();

        BorrowLog::create([
          'user_id' => $member->id,
          'book_id' => $book1->id,
          'is_returned' => 0,
        ]);

        BorrowLog::create([
          'user_id' => $member->id,
          'book_id' => $book2->id,
          'is_returned' => 0,
        ]);

        BorrowLog::create([
          'user_id' => $member->id,
          'book_id' => $book3->id,
          'is_returned' => 1,
        ]);
    }
}
