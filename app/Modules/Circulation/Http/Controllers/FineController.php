<?php

namespace App\Modules\Circulation\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Circulation\Models\Fine;
use App\Modules\Circulation\Services\LoanService;
use App\Modules\Membership\Contracts\MemberDirectory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FineController extends Controller
{
    public function index(MemberDirectory $members): View
    {
        $fines = Fine::with('loan')->orderByRaw('paid_at is not null')->latest('id')->paginate(10);

        return view('circulation::fines.index', [
            'fines' => $fines,
            'memberLabels' => $members->labels($fines->pluck('loan.member_id')->unique()->all()),
        ]);
    }

    public function pay(Fine $fine, LoanService $loans): RedirectResponse
    {
        $loans->payFine($fine);

        return back()->with('success', "Denda #{$fine->id} ditandai lunas.");
    }
}
