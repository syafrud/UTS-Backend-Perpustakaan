<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Catalog\Models\Author;
use App\Modules\Catalog\Models\Book;
use App\Modules\Catalog\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/circulation/loans')->assertRedirect('/login');
    }

    public function test_register_creates_pustakawan_and_logs_in(): void
    {
        $this->post('/register', [
            'name' => 'Budi',
            'email' => 'budi@test.id',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->assertSame('pustakawan', User::firstWhere('email', 'budi@test.id')->role);
    }

    public function test_register_validation_errors(): void
    {
        $this->post('/register', ['name' => '', 'email' => 'bukan-email', 'password' => '1', 'password_confirmation' => '2'])
            ->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_login_with_wrong_password_fails(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'salah'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_pustakawan_cannot_manage_books(): void
    {
        $pustakawan = User::factory()->create();

        $this->actingAs($pustakawan)->get('/catalog/books/create')->assertForbidden();
        $this->actingAs($pustakawan)->post('/catalog/books', [])->assertForbidden();
        $this->actingAs($pustakawan)->get('/membership/types')->assertForbidden();
        $this->actingAs($pustakawan)->get('/catalog/books')->assertOk();
    }

    public function test_admin_can_create_book_with_authors_pivot(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $authors = Author::factory(2)->create();

        $this->actingAs($admin)->post('/catalog/books', [
            'category_id' => $category->id,
            'title' => 'Belajar Laravel',
            'isbn' => '978-602-1234-56-7',
            'stock' => 3,
            'author_ids' => $authors->pluck('id')->all(),
        ])->assertRedirect();

        $book = Book::firstWhere('title', 'Belajar Laravel');
        $this->assertSame(['utama', 'pendamping'], $book->authors()->orderBy('author_book.id')->pluck('author_book.role')->all());
    }

    public function test_api_requires_token_and_issues_one(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->getJson('/api/catalog/books')->assertUnauthorized();

        $token = $this->postJson('/api/login', ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertOk()->json('token');

        $this->withToken($token)->getJson('/api/catalog/books')->assertOk()->assertJsonStructure(['data']);
    }
}
