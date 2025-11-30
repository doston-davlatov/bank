<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $query = AuditLog::orderBy('created_at', 'desc');
        if ($userId = $request->query('user_id')) {
            $query->where('user_id', $userId);
        }
        return response()->json($query->paginate(20));
    }

    // Boshqa metodlar kerak emas, faqat admin uchun o'qish
}
