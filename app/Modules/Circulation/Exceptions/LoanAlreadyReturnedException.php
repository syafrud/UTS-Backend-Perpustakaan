<?php

namespace App\Modules\Circulation\Exceptions;

use App\Support\Exceptions\BusinessRuleException;

class LoanAlreadyReturnedException extends BusinessRuleException
{
    public static function for(int $loanId, string $date): self
    {
        return new self("Peminjaman #{$loanId} sudah dikembalikan pada {$date}.");
    }
}
