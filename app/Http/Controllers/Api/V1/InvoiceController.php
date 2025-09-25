<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $invoices = $user->invoices()->latest()->get();

        return response()->json([
            'message' => 'Invoices retrieved successfully',
            'data' => $invoices,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $invoice = Invoice::create($data);

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice): JsonResponse
    {
        if ($invoice->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access to invoice',
            ], Response::HTTP_FORBIDDEN);
        }

        return response()->json([
            'message' => 'Invoice retrieved successfully',
            'data' => $invoice,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        if ($invoice->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access to invoice',
            ], Response::HTTP_FORBIDDEN);
        }

        $invoice->update($request->validated());

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        if ($invoice->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Unauthorized access to invoice',
            ], Response::HTTP_FORBIDDEN);
        }

        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully',
        ], Response::HTTP_OK);
    }
}
