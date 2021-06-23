<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Jobs\CallBackJob;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $newCompany = new Company();
        $newCompany->site_url = $request->input('site_url');
        $newCompany->name = $request->input('name');
        $newCompany->last_name = $request->input('last_name');
        $newCompany->company_name = $request->input('company_name');
        $newCompany->email = $request->input('email');
        $newCompany->password = Hash::make($request->input('password'));
        $newCompany->save();

        $token = $newCompany->createToken($newCompany->name);

        CallBackJob::dispatch([
            'action' => 'create',
            'model' => 'Company',
            'data' => $newCompany
        ]);
        return response()->json([
            'status' => 'success',
            'token' => $token->plainTextToken,
            'company_id' => $newCompany->id
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
