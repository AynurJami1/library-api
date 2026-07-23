<?php
namespace App\Services;

use App\Repositories\BookRepository;

class BookService
{
    protected $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($sort, $order)
    {
        return $this->repository->all($sort, $order);
    }

    public function getOne($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateBook($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}