<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Xavfsizlik uchun
    }

    public function index(Request $request)
    {
        $query = Account::with('holds', 'logs'); // Relationships qo'shish
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%")->orWhere('balance', 'like', "%{$search}%");
        }
        return response()->json($query->paginate(10));
    }

    public function store(StoreAccountRequest $request)
    {
        $account = Account::create($request->validated() + ['user_id' => auth()->id()]); // Foydalanuvchi bog'lash
        return response()->json($account, 201);
    }

    public function show(Account $account)
    {
        $this->authorize('view', $account); // Policy bilan xavfsizlik
        return response()->json($account->load('holds', 'logs'));
    }

    public function update(UpdateAccountRequest $request, Account $account)
    {
        $this->authorize('update', $account);
        $account->update($request->validated());
        return response()->json($account);
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        $account->delete();
        return response()->json(null, 204);
    }
}
