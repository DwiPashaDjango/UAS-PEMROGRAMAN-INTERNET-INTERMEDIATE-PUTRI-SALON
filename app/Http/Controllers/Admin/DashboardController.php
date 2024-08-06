<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Desginer;
use App\Models\Pengembalian;
use App\Models\Product;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::role('Pengguna')->count();
        $designerCount = Desginer::count();
        $produkCount = Product::count();

        $totalSewa = Rent::where('status', '!=', 'pending')->sum('total');
        $totalDenda = Denda::sum('total_denda');
        $ammount = $totalSewa + $totalDenda;

        return view('admin.dashboard', compact('usersCount', 'designerCount', 'produkCount', 'ammount'));
    }

    public function statistikRent(Request $request)
    {
        $year = $request->years;
        $months = range(1, 12);

        $rents = Rent::where('status', '!=', 'pending')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();

        $renteds = Pengembalian::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get();


        $rentResult = [];
        foreach ($months as $month) {
            $rent = $rents->where('month', $month)->first();

            $rentResult[] = [
                'month' => $month,
                'count' => $rent ? $rent->count : 0,
            ];
        }

        $rentedResult = [];
        foreach ($months as $month) {
            $rented = $renteds->where('month', $month)->first();

            $rentedResult[] = [
                'month' => $month,
                'count' => $rented ? $rented->count : 0,
            ];
        }

        return response()->json(['rent' => $rentResult, 'rented' => $rentedResult]);
    }
}
