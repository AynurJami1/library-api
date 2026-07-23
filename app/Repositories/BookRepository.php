<?php
namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function all($sort = 'id', $order = 'asc')
    {
        return Book::orderBy($sort, $order)->paginate(10);
    }

    public function find($id)
    {
        return Book::findOrFail($id);
    }

    public function create(array $data)
    {
        return Book::create($data);
    }

    public function update($id, array $data)
    {
        $book = $this->find($id);
        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $book = $this->find($id);
        $book->delete();
    }
}