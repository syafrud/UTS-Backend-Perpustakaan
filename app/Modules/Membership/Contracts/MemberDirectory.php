<?php

namespace App\Modules\Membership\Contracts;

use App\Modules\Membership\Exceptions\MemberNotEligibleException;

/**
 * Pintu publik MembershipModule untuk modul lain.
 */
interface MemberDirectory
{
    /**
     * Data anggota aktif beserta aturan jenis keanggotaannya.
     *
     * @return array{id:int,member_code:string,name:string,max_loans:int,loan_days:int,fine_per_day:int}
     *
     * @throws MemberNotEligibleException jika anggota tidak ada / nonaktif
     */
    public function findActive(int $memberId): array;

    /** @return array<int,string> id => "KODE - Nama" untuk anggota aktif */
    public function activeOptions(): array;

    /** @param  int[]  $memberIds  @return array<int,string> id => "KODE - Nama" */
    public function labels(array $memberIds): array;
}
