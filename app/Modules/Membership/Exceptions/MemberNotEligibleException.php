<?php

namespace App\Modules\Membership\Exceptions;

use App\Support\Exceptions\BusinessRuleException;

class MemberNotEligibleException extends BusinessRuleException
{
    public static function notFound(int $memberId): self
    {
        return new self("Anggota dengan ID {$memberId} tidak ditemukan.");
    }

    public static function inactive(string $name): self
    {
        return new self("Keanggotaan \"{$name}\" sedang nonaktif, tidak dapat melakukan peminjaman.");
    }
}
