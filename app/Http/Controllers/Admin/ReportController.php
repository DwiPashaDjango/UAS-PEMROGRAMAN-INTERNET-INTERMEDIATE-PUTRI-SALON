<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Rent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month;
        $years = $request->year;

        if (!empty($month) && !empty($years)) {
            $rents = Rent::with('user', 'product')->where('status', '!=', 'pending')
                ->whereMonth('created_at', (int)$month)
                ->whereYear('created_at', (int)$years)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $rents = Rent::with('user', 'product')->where('status', '!=', 'pending')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('admin.report.index', ['rents' => $rents, 'month' => $month, 'years' => $years]);
    }

    public function printReportRent($month, $years)
    {
        $rents = Rent::with('user', 'product')->where('status', '!=', 'pending')
            ->whereMonth('created_at', (int)$month)
            ->whereYear('created_at', (int)$years)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.report.print-rent', compact('rents', 'month', 'years'));
    }

    public function rented(Request $request)
    {
        $month = $request->month;
        $years = $request->year;

        if (!empty($month) && !empty($years)) {
            $renteds = Pengembalian::with('user', 'product', 'rent', 'denda')
                ->whereMonth('created_at', (int)$month)
                ->whereYear('created_at', (int)$years)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $renteds = Pengembalian::with('user', 'product')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->orderBy('id', 'DESC')
                ->get();
        }

        return view('admin.report.rented', ['renteds' => $renteds, 'month' => $month, 'years' => $years]);
    }

    public function printReportRented($month, $years)
    {
        $renteds = Pengembalian::with('user', 'product', 'rent', 'denda')
            ->whereMonth('created_at', (int)$month)
            ->whereYear('created_at', (int)$years)
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.report.print-rented', compact('renteds', 'month', 'years'));
    }
}
