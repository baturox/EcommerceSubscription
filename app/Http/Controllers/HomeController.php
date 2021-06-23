<?php

namespace App\Http\Controllers;

use App\Models\CompanyPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('start_date')) {
            $getCompanyPaymentsSuccess = CompanyPayment::where([
                ['created_at', '>', Carbon::now()->subDay(7)],
                ['status', '=', 'success']
            ])->sum('price');

            $getCompanyPaymentsFail = CompanyPayment::where([
                ['created_at', '>', Carbon::now()->subDay(7)],
                ['status', '=', 'fail']
            ])->sum('price');

            $getCompanyPayments = CompanyPayment::where([
                ['created_at', '>', Carbon::now()->subDay(7)]
            ])->simplePaginate(25);
        } else {

            $startDay = $request->input('start_date');
            $endDay = date('Y-m-d', strtotime($request->input('end_date')) + 60 * 60 * 24);

            $getCompanyPaymentsSuccess = CompanyPayment::where('status', '=', 'success')
                ->whereBetween('created_at', [$startDay, $endDay])
                ->sum('price');

            $getCompanyPaymentsFail = CompanyPayment::where('status', '=', 'success')
                ->whereBetween('created_at', [$startDay, $endDay])
                ->sum('price');

            $getCompanyPayments = CompanyPayment::whereBetween('created_at', [$startDay, $endDay])
                ->simplePaginate(25);
        }

        return view('reporting', [
            'payments' => $getCompanyPayments,
            'successTotal' => $getCompanyPaymentsSuccess,
            'failTotal' => $getCompanyPaymentsFail
        ]);
    }
}
