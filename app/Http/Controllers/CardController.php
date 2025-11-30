<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Kartalar ro‘yxati (pagination bilan, eng so‘nggi chiqarilgan yuqorida)
        $cards = Card::orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $cards
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $card = Card::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Card created successfully',
            'data' => $card
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Card $card)
    {
        return response()->json([
            'success' => true,
            'data' => $card
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        $card->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Card updated successfully',
            'data' => $card
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card)
    {
        // soft delete
        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'Card deleted successfully'
        ]);
    }
}
