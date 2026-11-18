<?php

namespace App\Modules\Circulation\Events;

use Illuminate\Foundation\Events\Dispatchable;

/**
 * Domain Event: peminjaman telah dikembalikan.
 * Dipublikasikan oleh CirculationModule; modul lain (Catalog) bereaksi tanpa
 * Circulation perlu tahu siapa pendengarnya. Payload hanya data primitif.
 */
class LoanReturned
{
    use Dispatchable;

    /** @param  int[]  $bookIds */
    public function __construct(
        public readonly int $loanId,
        public readonly int $memberId,
        public readonly array $bookIds,
        public readonly string $returnedAt,
        public readonly int $daysLate,
    ) {}
}
