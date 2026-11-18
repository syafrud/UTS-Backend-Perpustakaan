<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Catalog\Models\Book;
use App\Modules\Circulation\Events\LoanReturned;
use App\Modules\Circulation\Models\Loan;
use App\Modules\Circulation\Services\LoanService;
use App\Modules\Membership\Models\Member;
use App\Modules\Membership\Models\MembershipType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CirculationTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Member $member;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $type = MembershipType::factory()->create(['max_loans' => 3, 'loan_days' => 7, 'fine_per_day' => 1000]);
        $this->member = Member::factory()->for($type, 'type')->create();
    }

    public function test_borrow_decrements_stock(): void
    {
        $book = Book::factory()->create(['stock' => 2]);

        $this->actingAs($this->user)
            ->post('/circulation/loans', ['member_id' => $this->member->id, 'book_ids' => [$book->id]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame(1, $book->fresh()->stock);
        $this->assertDatabaseCount('loans', 1);
    }

    public function test_out_of_stock_rolls_back_whole_transaction(): void
    {
        $available = Book::factory()->create(['stock' => 1]);
        $empty = Book::factory()->outOfStock()->create();

        $this->actingAs($this->user)
            ->from('/circulation/loans/create')
            ->post('/circulation/loans', ['member_id' => $this->member->id, 'book_ids' => [$available->id, $empty->id]])
            ->assertRedirect('/circulation/loans/create')
            ->assertSessionHas('error', fn ($msg) => str_contains($msg, 'habis'));

        // Stok buku pertama tidak berkurang & tidak ada loan tersimpan.
        $this->assertSame(1, $available->fresh()->stock);
        $this->assertDatabaseCount('loans', 0);
        $this->assertDatabaseCount('loan_items', 0);
    }

    public function test_loan_limit_is_enforced(): void
    {
        $books = Book::factory(4)->create(['stock' => 5]);

        $this->actingAs($this->user)
            ->post('/circulation/loans', ['member_id' => $this->member->id, 'book_ids' => $books->pluck('id')->all()])
            ->assertSessionHas('error', fn ($msg) => str_contains($msg, 'melebihi batas 3'));

        $this->assertDatabaseCount('loans', 0);
    }

    public function test_inactive_member_cannot_borrow(): void
    {
        $this->member->update(['is_active' => false]);
        $book = Book::factory()->create();

        $this->actingAs($this->user)
            ->post('/circulation/loans', ['member_id' => $this->member->id, 'book_ids' => [$book->id]])
            ->assertSessionHas('error', fn ($msg) => str_contains($msg, 'nonaktif'));
    }

    public function test_borrow_validation(): void
    {
        $this->actingAs($this->user)
            ->post('/circulation/loans', ['member_id' => '', 'book_ids' => []])
            ->assertSessionHasErrors(['member_id', 'book_ids']);
    }

    public function test_late_return_creates_fine_and_restores_stock(): void
    {
        $book = Book::factory()->create(['stock' => 1]);
        $loan = app(LoanService::class)->borrow($this->member->id, [$book->id]);
        $loan->update(['loaned_at' => today()->subDays(10), 'due_at' => today()->subDays(3)]);

        $this->actingAs($this->user)
            ->post("/circulation/loans/{$loan->id}/return", ['returned_at' => today()->toDateString()])
            ->assertSessionHas('success');

        $this->assertSame(1, $book->fresh()->stock);
        $this->assertDatabaseHas('fines', ['loan_id' => $loan->id, 'days_late' => 3, 'amount' => 3000]);
    }

    public function test_return_publishes_loan_returned_domain_event(): void
    {
        Event::fake([LoanReturned::class]);
        $books = Book::factory(2)->create(['stock' => 1]);
        $loan = app(LoanService::class)->borrow($this->member->id, $books->pluck('id')->all());
        $loan->update(['loaned_at' => today()->subDays(9), 'due_at' => today()->subDays(2)]);

        app(LoanService::class)->return($loan);

        Event::assertDispatched(LoanReturned::class, fn (LoanReturned $e) => $e->loanId === $loan->id
            && $e->bookIds === $books->pluck('id')->all()
            && $e->daysLate === 2);
        // Listener dipalsukan -> stok tidak kembali; membuktikan stok dikelola Catalog, bukan Circulation.
        $this->assertSame(0, $books->first()->fresh()->stock);
    }

    public function test_on_time_return_has_no_fine_and_cannot_return_twice(): void
    {
        $book = Book::factory()->create(['stock' => 1]);
        $loan = app(LoanService::class)->borrow($this->member->id, [$book->id]);

        $this->actingAs($this->user)->post("/circulation/loans/{$loan->id}/return", ['returned_at' => today()->toDateString()]);
        $this->assertDatabaseCount('fines', 0);

        $this->actingAs($this->user)
            ->post("/circulation/loans/{$loan->id}/return", ['returned_at' => today()->toDateString()])
            ->assertSessionHas('error', fn ($msg) => str_contains($msg, 'sudah dikembalikan'));
        $this->assertSame(1, $book->fresh()->stock);
    }

    public function test_return_date_cannot_be_in_future(): void
    {
        $loan = app(LoanService::class)->borrow($this->member->id, [Book::factory()->create()->id]);

        $this->actingAs($this->user)
            ->post("/circulation/loans/{$loan->id}/return", ['returned_at' => today()->addDay()->toDateString()])
            ->assertSessionHasErrors('returned_at');
        $this->assertNull(Loan::find($loan->id)->returned_at);
    }
}
