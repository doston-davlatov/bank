<?php

namespace App\Http\Controllers;

use App\Models\AccountHold;
use App\Http\Requests\StoreAccountHoldRequest;
use App\Http\Requests\UpdateAccountHoldRequest;
use Illuminate\Http\Request;

class AccountHoldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $query = AccountHold::with('account');
        if ($accountId = $request->query('account_id')) {
            $query->where('account_id', $accountId);
        }
        return response()->json($query->paginate(10));
    }

    public function store(StoreAccountHoldRequest $request)
    {
        $hold = AccountHold::create($request->validated());
        return response()->json($hold, 201);
    }

    public function show(AccountHold $accountHold)
    {
        $this->authorize('view', $accountHold);
        return response()->json($accountHold->load('account'));
    }

    public function update(UpdateAccountHoldRequest $request, AccountHold $accountHold)
    {
        $this->authorize('update', $accountHold);
        $accountHold->update($request->validated());
        return response()->json($accountHold);
    }

    public function destroy(AccountHold $accountHold)
    {
        $this->authorize('delete', $accountHold);
        $accountHold->delete();
        return response()->json(null, 204);
    }
}
