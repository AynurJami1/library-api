<?php
namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
#[OA\Info(title: "Library API", version: "1.0.0", description: "Kitabxana idarəetməsi üçün CRUD REST API")]
class BookController extends Controller
{
    protected $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }
 #[OA\Get(
        path: "/api/books",
        summary: "Bütün kitabları göstər (səhifələmə və çeşidləmə ilə)",
        parameters: [
            new OA\Parameter(name: "sort", in: "query", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "order", in: "query", schema: new OA\Schema(type: "string")),
        ],
        responses: [new OA\Response(response: 200, description: "Uğurlu")]
    )]
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'id');
        $order = $request->query('order', 'asc');
        return response()->json($this->service->getAll($sort, $order), 200);
    }
#[OA\Get(
    path: "/api/books/{id}",
    summary: "Tək kitabı göstər",
    parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
    responses: [
        new OA\Response(response: 200, description: "Uğurlu"),
        new OA\Response(response: 404, description: "Tapılmadı"),
    ]
)]
    public function show($id)
    {
        return response()->json($this->service->getOne($id), 200);
    }
#[OA\Post(
    path: "/api/books",
    summary: "Yeni kitab yarat",
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string"),
                new OA\Property(property: "isbn", type: "string"),
                new OA\Property(property: "author_id", type: "integer"),
                new OA\Property(property: "published_year", type: "integer"),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: "Yaradıldı"),
        new OA\Response(response: 422, description: "Doğrulama xətası"),
    ]
)]
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
#[OA\Put(
    path: "/api/books/{id}",
    summary: "Kitabı yenilə",
    parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
    responses: [
        new OA\Response(response: 200, description: "Yeniləndi"),
        new OA\Response(response: 404, description: "Tapılmadı"),
    ]
)]
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
#[OA\Delete(
    path: "/api/books/{id}",
    summary: "Kitabı sil",
    parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
    responses: [
        new OA\Response(response: 204, description: "Silindi"),
        new OA\Response(response: 404, description: "Tapılmadı"),
    ]
)]
    public function destroy($id)
    {
        $this->service->destroy($id);
        return response()->json(null, 204);
    }
}