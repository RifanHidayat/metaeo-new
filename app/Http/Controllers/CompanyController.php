<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = Company::find($id);
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->fax = $request->fax;
        $company->address = $request->address;
        $company->head = $request->head;
        // $company->logo = $request->logo;
        if ($request->hasFile('logo')) {
            try {
                $file = $request->file('logo');
                $filePath = 'images/' . time() . '-company_logo' . '.' . $request->file('logo')->extension();
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                Storage::disk('s3')->delete($company->logo);
                $company->logo = $filePath;
            } catch (Exception $e) {
                return response()->json([
                    'message' => '[Internal error] Upload file failed',
                    'code' => 500,
                    'error' => true,
                    'errors' => $e,
                ], 500);
            }
        } else {
            if ($company->logo !== null) {
                try {
                    Storage::disk('s3')->delete($company->logo);
                    $company->logo = null;
                } catch (Exception $e) {
                    return response()->json([
                        'message' => '[Internal error] Delete file failed',
                        'code' => 500,
                        'error' => true,
                        'errors' => $e,
                    ], 500);
                }
            }
        }

        try {
            $company->save();
            return response()->json([
                'message' => 'Data has been saved',
                'code' => 200,
                'error' => false,
                // 'errors' => $e,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Internal error',
                'code' => 500,
                'error' => true,
                'errors' => $e,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
