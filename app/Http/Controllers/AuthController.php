<?php

namespace App\Http\Controllers;

use App\Mail\DemoRequestMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AuthController extends Controller
{

    public function demoRequest(Request $request)
    {

        $email = $request->email;
        $phone = $request->phone;
        $name = $request->name;

        $isExist = DB::connection('mysql_main')->table('users')->where('email', '=', $email)->orWhere('phone', '=', $phone)->first();

        if ($isExist) {

            $result = [
                'status' => 'error',
                'message' => 'Provided Details Already Exists',
            ];
            return response()->json($result, 200)->header('Content-Type', "application/json");

        } else {

//            $password = $this->generateRandomString(5);
            $password = 1234;

            $saveData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'ip_address' => $request->ip(),
                'active_date_time' => date('Y-m-d'),
                'country' => 'Nepal',
                'uuid' => Str::orderedUuid()->toString()
            ];

//            Mail::to($email)->send(new DemoRequestMail($saveData));


            DB::connection('mysql_main')->table('users')->insert($saveData);

            $result = [
                'status' => 'success',
                'message' => 'Thank you for using EntryBooks',
                'result' => null
            ];

            return response()->json($result, 200)->header('Content-Type', "application/json");

        }

    }

    public function demoLogin(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        $user = DB::connection('mysql_main')->table("users")->where([
            'status' => 1,
            'email' => $email
        ])->first();

        if (!$user) {

            $result = [
                'status' => 'error',
                'message' => 'User not found.'
            ];

            return response()->json($result, 200)->header('Content-Type', "application/json");
        }

        if (Hash::check($password, $user->password)) {

            if ($user->company_id == null) {

                $result = [
                    'id' => $user->uuid,
                    'email' => $email,
                    'status' => 'company',
                    'message' => 'Setup your company'
                ];

                return response()->json($result, 200)->header('Content-Type', "application/json");

            } else {

                $url = "https://entrybooks.net";

                $result = [
                    'status' => 'success',
                    'message' => $url
                ];

                return response()->json($result, 200)->header('Content-Type', "application/json");

            }

        } else {
            $result = [
                'status' => 'error',
                'message' => 'Wrong password'
            ];

            return response()->json($result, 200)->header('Content-Type', "application/json");
        }
    }

    public function demoCompany(Request $request)
    {

        $name = $request->name;
        $address = $request->address;
        $vatno = $request->vatpan;
        $type = $request->type;
        $contact = $request->contact;
        $uuid = $request->userId;
        $userEmail = $request->userEmail;

        $company = DB::connection('mysql_main')->table('company')->where([
            'vatpan' => $vatno
        ])->first();

        if ($company) {
            $result = [
                'status' => 'error',
                'message' => 'Company already exits'
            ];
            return response()->json($result, 200)->header('Content-Type', "application/json");
        }

        $saved = DB::connection('mysql_main')->table('company')->insertGetId([
            'name' => $name,
            'address' => $address,
            'vatpan' => $vatno,
            'phone' => $contact,
            'status' => 1,
            'active_date_time' => date('Y-m-d'),
            'cuid' => Str::orderedUuid()->toString(),
            'country' => 'Nepal'
        ]);

        if ($saved) {

            DB::connection('mysql_main')->table('users')->where([
                'uuid' => $uuid
            ])->update([
                'company_id' => $saved,
                'updated_at' => now()
            ]);

            $url = "https://entrybooks.net";
            $result = [
                'status' => 'success',
                'message' => $url
            ];

            return response()->json($result, 200)->header('Content-Type', "application/json");


        } else {

            $result = [
                'status' => 'error',
                'message' => 'Failed to save company information'
            ];

            return response()->json($result, 200)->header('Content-Type', "application/json");

        }


    }


    private function generateRandomString($length = 7)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
