<?php

namespace App\Modules\Circulation\Exceptions;

use App\Support\Exceptions\BusinessRuleException;

class LoanLimitExceededException extends BusinessRuleException
{
    public static function for(string $memberName, int $max, int $current, int $requested): self
    {
        return new self(
            "{$memberName} sedang meminjam {$current} buku; menambah {$requested} buku akan melebihi batas {$max} buku untuk jenis keanggotaannya."
        );
    }
}
