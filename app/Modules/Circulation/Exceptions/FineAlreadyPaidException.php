<?php

namespace App\Modules\Circulation\Exceptions;

use App\Support\Exceptions\BusinessRuleException;

class FineAlreadyPaidException extends BusinessRuleException
{
    public static function for(int $fineId): self
    {
        return new self("Denda #{$fineId} sudah lunas.");
    }
}
