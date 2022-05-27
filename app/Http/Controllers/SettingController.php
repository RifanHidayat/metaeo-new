<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Tax;
use App\Models\TaxSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function account()
    {

        if (!Auth::check()) {
            return redirect('login');
        }

        $userId = Auth::id();
        $user = User::find($userId);
        return view('setting.account', [
            'user' => $user,
        ]);
    }

    public function company()
    {
        $company = Company::all()->first();

        if ($company == null) {
            $company = new Company;
            $company->save();
            // $company = $company;
        }

        return view('setting.company', [
            'company' => $company,
        ]);
    }
     public function tax()
    {
        $tax = TaxSetting::all()->first();
       

        return view('setting.tax', [
            'tax' => $tax,
        ]);
    }
}
