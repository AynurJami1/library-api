<?php
namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'asc');
        return response()->json($this->service->getAll($sort, $order), 200);
    }

    public function show($id)
    {
        return response()->json($this->service->getOne($id), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'author_id' => 'required|exists:authors,id',
            'published_year' => 'nullable|integer',
        ]);

        $book = $this->service->store($validated);
        return response()->json($book, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'isbn' => 'sometimes|string|unique:books,isbn,' . $id,
            'author_id' => 'sometimes|exists:authors,id',
            'published_year' => 'nullable|integer',
        ]);

        $book = $this->service->updateBook($id, $validated);
        return response()->json($book, 200);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(null, 204);
    }
}