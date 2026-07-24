<?php
namespace Tests\Unit;

use App\Models\Book;
use App\Repositories\BookRepository;
use App\Services\BookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_book(): void
    {
        $service = new BookService(new BookRepository());
        $author = \App\Models\Author::factory()->create();

        $book = $service->store([
            'title' => 'Test Kitab',
            'isbn' => '1234567890123',
            'author_id' => $author->id,
            'published_year' => 2020,
        ]);

        $this->assertInstanceOf(Book::class, $book);
        $this->assertEquals('Test Kitab', $book->title);
        $this->assertDatabaseHas('books', ['title' => 'Test Kitab']);
    }

    public function test_it_can_get_all_books(): void
    {
        $service = new BookService(new BookRepository());
        Book::factory()->count(3)->create();

        $result = $service->getAll('id', 'asc');

        $this->assertEquals(3, $result->total());
    }

    public function test_it_can_delete_a_book(): void
    {
        $service = new BookService(new BookRepository());
        $book = Book::factory()->create();

        $service->destroy($book->id);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}