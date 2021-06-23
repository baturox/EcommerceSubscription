<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyPackageRequest;
use App\Http\Resources\CompanyPackageResource;
use App\Jobs\CallBackJob;
use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user();
        return response()->json(CompanyPackageResource::collection($company->packages));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyPackageRequest $request)
    {
        $company = Auth::user();
        $package = Package::find($request->input('package_id'));

        if ($package) {
            $newCompanyPackage = new CompanyPackage();
            $newCompanyPackage->company_id = $company->id;
            $newCompanyPackage->package_id = $package->id;
            $newCompanyPackage->start_date = Carbon::now();
            if ($package->type == 'mounthly') {
                $newCompanyPackage->end_date = Carbon::now()->addDay(30);
            } else {
                $newCompanyPackage->end_date = Carbon::now()->addDay(365);
            }
            $newCompanyPackage->status = 'active';
            $newCompanyPackage->save();

            CallBackJob::dispatch([
                'action' => 'create',
                'model' => 'CompanyPackage',
                'data' => $newCompanyPackage
            ]);

            return response()->json([
                'status' => 'success',
                'start_date' => $newCompanyPackage->start_date,
                'end_date' => $newCompanyPackage->end_date,
                'package' => $package,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Company or Package not found'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
