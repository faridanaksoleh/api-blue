<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\WithdrawalResource;
use App\Interfaces\WithdrawalRepositoryInterface;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    private WithdrawalRepositoryInterface $withdrawalRepository;

    public function __construct(WithdrawalRepositoryInterface $withdrawalRepository)
    {
        $this->withdrawalRepository = $withdrawalRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $withdrawals = $this->withdrawalRepository->getAll(
                $request->search,
                $request->limit,
                true
            );

            return ResponseHelper::jsonResponse(true, 'Data Withdrawal Berhasil Diambil', WithdrawalResource::collection($withdrawals), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'nullable|integer',

        ]);

        try {
            $withdrawals = $this->withdrawalRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page'],
            );

            return ResponseHelper::jsonResponse(true, 'Data Withdrawal Berhasil Diambil', PaginateResource::make($withdrawals, WithdrawalResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $withdrawal = $this->withdrawalRepository->getById($id);

            if(!$withdrawal) {
                return ResponseHelper::jsonResponse(true, 'Data Withdrawal Tidak Ditemukan', null, 404);

            }

            return ResponseHelper::jsonResponse(true, 'Data Withdrawal Berhasil Diambil', new WithdrawalResource($withdrawal), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

