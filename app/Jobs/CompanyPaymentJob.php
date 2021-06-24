<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\CompanyPayment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompanyPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $companyPackage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CompanyPackage $companyPackage)
    {
        $this->companyPackage = $companyPackage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $company = $this->companyPackage->company;
        $package = $this->companyPackage->package;

        $getLastFailedPayment = $company->payments()
            ->whereDate('created_at', Carbon::today())
            ->exists();
        if (!$getLastFailedPayment) {
            $makePayment = new CompanyPayment();
            $makePayment->company_id = $company->id;
            $makePayment->price = $package->price;
            $makePayment->status = $this->doPayment();
            $makePayment->save();

            CallBackJob::dispatch([
                'action' => 'create',
                'model' => 'CompanyPayment',
                'data' => $makePayment
            ]);

            if ($makePayment->status == 'success') {
                $this->companyPackage->end_date = Carbon::parse($this->companyPackage->end_date)
                    ->addDay($package->type == 'monthly' ? 30 : 365);
                $this->companyPackage->save();
            }

            $getTriedCount = $company->payments()->where([
                ['created_at', '>', Carbon::now()->subDays(4)],
                ['status', '=', 'fail']
            ])->count();

            if ($getTriedCount >= 3) {
                $company->canceled_at = Carbon::now();
                $company->save();

                CallBackJob::dispatch([
                    'action' => 'cancel',
                    'model' => 'Company',
                    'data' => $company
                ]);
            }
        }
    }

    private function doPayment()
    {
        $customHash = rand(0, 999);
        if ($customHash % 2) {
            return 'success';
        }
        return 'fail';
    }
}
