<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    //

    public function index(Request $request)
    {

        $type = $request->input('type');

        if ($type == 'all') {
            $result = [
                'customer' => DB::table("customers")->where([
                    'status' => 1
                ])->get(),
                'supplier' => DB::table("suppliers")->where([
                    'status' => 1
                ])->get(),
                'bank' => DB::table("banks")->where([
                    'status' => 1
                ])->get(),
                'income' => DB::table("incomes")->where([
                    'status' => 1
                ])->get(),
                'expense' => DB::table("expenses")->where([
                    'status' => 1
                ])->get(),
                'account' => DB::table("accounts")->where([
                    'status' => 1
                ])->get(),
            ];
            return response()->json($result, 200)->header('Content-Type', "application/json");
        }

        if ($type == 'customer') {
            $result = DB::table("customers")->where([
                'status' => 1
            ])->get();
        }

        if ($type == 'supplier') {
            $result = DB::table("suppliers")->where([
                'status' => 1
            ])->get();
        }

        if ($type == 'expense') {
            $result = DB::table("expenses")->where([
                'status' => 1
            ])->get();
        }

        if ($type == 'income') {
            $result = DB::table("incomes")->where([
                'status' => 1
            ])->get();
        }

        if ($type == 'bank') {
            $result = DB::table("banks")->where([
                'status' => 1
            ])->get();
        }

        return response()->json($result, 200)->header('Content-Type', "application/json");

    }

}
