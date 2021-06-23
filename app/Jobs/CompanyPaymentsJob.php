<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanyPackage;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompanyPaymentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $companies = CompanyPackage::where('end_date', '<', Carbon::now())
            ->whereHas('company', function ($query) {
                $query->whereNull('canceled_at');
            })
            ->get();

        foreach ($companies as $company) {
            CompanyPaymentJob::dispatch($company);
        }
    }
}
