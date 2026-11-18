<?php

namespace App\Modules\Membership\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Membership\Http\Requests\MembershipTypeRequest;
use App\Modules\Membership\Models\MembershipType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MembershipTypeController extends Controller
{
    public function index(): View
    {
        return view('membership::types.index', [
            'types' => MembershipType::withCount('members')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('membership::types.form', ['type' => new MembershipType]);
    }

    public function store(MembershipTypeRequest $request): RedirectResponse
    {
        MembershipType::create($request->validated());

        return redirect()->route('membership.types.index')->with('success', 'Jenis keanggotaan ditambahkan.');
    }

    public function edit(MembershipType $type): View
    {
        return view('membership::types.form', compact('type'));
    }

    public function update(MembershipTypeRequest $request, MembershipType $type): RedirectResponse
    {
        $type->update($request->validated());

        return redirect()->route('membership.types.index')->with('success', 'Jenis keanggotaan diperbarui.');
    }

    public function destroy(MembershipType $type): RedirectResponse
    {
        if ($type->members()->exists()) {
            return back()->with('error', "Jenis \"{$type->name}\" masih dipakai anggota, tidak bisa dihapus.");
        }

        $type->delete();

        return back()->with('success', 'Jenis keanggotaan dihapus.');
    }
}
