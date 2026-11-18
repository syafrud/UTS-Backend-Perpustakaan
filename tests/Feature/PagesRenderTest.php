<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Catalog\Models\Book;
use App\Modules\Circulation\Models\Loan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesRenderTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_admin_pages_render(): void
    {
        $this->seed();
        $admin = User::firstWhere('role', 'admin');
        $book = Book::first();
        $loan = Loan::first();

        $pages = [
            '/dashboard', '/catalog/books', "/catalog/books/{$book->id}", '/catalog/books/create', "/catalog/books/{$book->id}/edit",
            '/catalog/categories', '/catalog/categories/create', '/catalog/authors', '/catalog/authors/create',
            '/membership/types', '/membership/types/create', '/membership/members', '/membership/members/create',
            '/circulation/loans', '/circulation/loans/create', "/circulation/loans/{$loan->id}", '/circulation/fines',
        ];

        foreach ($pages as $page) {
            $this->actingAs($admin)->get($page)->assertOk();
        }
    }

    public function test_guest_pages_render(): void
    {
        $this->get('/login')->assertOk();
        $this->get('/register')->assertOk();
    }
}
