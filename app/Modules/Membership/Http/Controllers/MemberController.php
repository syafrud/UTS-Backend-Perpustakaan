<?php

namespace App\Modules\Membership\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Membership\Http\Requests\MemberRequest;
use App\Modules\Membership\Models\Member;
use App\Modules\Membership\Models\MembershipType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $members = Member::with('type')
            ->when($request->q, fn ($q, $term) => $q->where('name', 'like', "%{$term}%")->orWhere('member_code', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('membership::members.index', compact('members'));
    }

    public function create(): View
    {
        return view('membership::members.form', ['member' => new Member(['is_active' => true]), 'types' => $this->types()]);
    }

    public function store(MemberRequest $request): RedirectResponse
    {
        $member = Member::create($request->validated());

        return redirect()->route('membership.members.index')->with('success', "Anggota {$member->label()} ditambahkan.");
    }

    public function edit(Member $member): View
    {
        return view('membership::members.form', ['member' => $member, 'types' => $this->types()]);
    }

    public function update(MemberRequest $request, Member $member): RedirectResponse
    {
        $member->update($request->validated());

        return redirect()->route('membership.members.index')->with('success', 'Data anggota diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return back()->with('success', 'Anggota dihapus.');
    }

    private function types()
    {
        return MembershipType::orderBy('name')->pluck('name', 'id');
    }
}
