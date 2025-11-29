<?php

namespace App\Http\Controllers;

use App\Models\Audit_log;
use App\Http\Requests\StoreAudit_logRequest;
use App\Http\Requests\UpdateAudit_logRequest;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAudit_logRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Audit_log $audit_log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Audit_log $audit_log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAudit_logRequest $request, Audit_log $audit_log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Audit_log $audit_log)
    {
        //
    }
}
