<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\Sale;
use App\Http\Requests\SellerRequest;
use App\Http\Resources\SellerResource;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailySalesReport;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();
        return SellerResource::collection($sellers);
    }

    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        return new SellerResource($seller);
    }


    public function store(SellerRequest $request)
    {
        $seller = Seller::create($request->validated());
        return new SellerResource($seller);
    }

    public function update(SellerRequest $request, Seller $seller)
    {
        $seller->update($request->validated());
        return new SellerResource($seller);
    }

    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function viewSeller($id)
    {
        $seller = Seller::findOrFail($id);
        return Inertia::render('ViewSeller', [
            'seller' => $seller
        ]);
    }

    public function newSeller()
    {
        return Inertia::render('NewSeller');
    }
    
    public function editSeller($id)
    {
        $seller = Seller::findOrFail($id);
        return Inertia::render('EditSeller', [
            'seller' => $seller
        ]);
    }

    public function sendSellerSummaryEmail($id)
    {
        try {
            $seller = Seller::findOrFail($id);

            $sales = Sale::where('seller_id', $seller->id)
                ->whereDate('created_at', today())
                ->get();

            $totalSales = $sales->count();
            $totalValue = $sales->sum('value');
            $totalCommission = $sales->sum('commission');

            Mail::to($seller->email)->send(new DailySalesReport($seller, $totalSales, $totalValue, $totalCommission));
        } catch (\Exception $th) {
            throw $th;
        }
    }
}
