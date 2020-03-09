<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\City;
use App\Doctor;
use App\Image;
use App\UserRole;
use App\Prescription;
use App\PrescriptionDe;
use App\Product;
use App\DrPrescription;
use App\TimeTable;
use App\Day;
use App\Pharmacy;
use App\Dosage;


class PrescriptionController extends Controller
{
    public function mobilePresShowAll(Request $request)
    {
         //authenticated user
        $isFailed = false;
        $data = [];
        $errors =  [];

        $api_token = $request -> api_token;
        $user = null;
        $user = User::where('api_token', $api_token)->first();

        if ($user == null){
            $isFailed = true;
            $errors []  = [ 'auth' => 'authentication failed'];
        }
        if ($isFailed == false){
            $prescriptions = Prescription::where('user_id',$user -> id )->get();
            $prescription = [];


            if($prescriptions->isEmpty()){
                $isFailed = true;
                $errors[] = ['error' => 'no prescriptions yet'];
            }
            else {

                foreach($prescriptions as $pres)
                {
                    //medicine_name
                    $medicine = $pres -> medicine_name;
                    //dosage
                    //$dosage = $pres -> dosage ;
                    //start hour
                    //$str_hour = $pres -> start_hour;
                    //frequency 
                    $freq = $pres -> frequency;
                    //end date 
                    //$eDate = $pre -> end_date;
                    //days in week 
                    $days = Day::where('id',$day -> id )->get();
                    //dosage time 
                    $id = $pres -> id ;
                    $dosage_time = Dosage::where('id' , $id)->get();



                

                    $prescription=[
                        'medicine' =>$medicine,
                        //'dosage' => $dosage,
                        //'start_hour' =>  $str_hour,
                        'frequency' =>  $freq,
                        'Days'=> $days,
                        'dosage_time' =>  $dosage_time
                    ];
                    $data []=$prescription;
                }
            }
        }
        $response = [
            'isFailed' => $isFailed,
            'data' => $data,
            'errors' => $errors
        ];
        return response()->json($response);
    }

    public function mobileCreatePrescription(Request $request){
        $isFailed = false;
        $data = [];
        $errors =  [];

        $api_token = $request -> api_token;
        $user = null;
        $user = User::where('api_token', $api_token)->first();

        if ($user == null){
            $isFailed = true;
            $errors []  = [ 'auth' => 'authentication failed'];
        }
        else{
            $prescription = new Prescription;
            $prescription -> medicine_name = $request -> medicine_name;
            $prescription -> dosage = $request -> dosage;
            $prescription -> days_interval = $request -> days_interval;
            $prescription -> hours_interval = $request -> hours_interval;
            $prescription -> start_hour = $request -> start_hour;
            $prescription -> user_id = $user -> id;

            $prescription -> save();

            $data += [
                'success' => 'prescription registered successfully'
            ];
        }

        $response = [
            'isFailed' => $isFailed,
            'data' => $data,
            'errors' => $errors
        ];
        return response()->json($response);
    }
}
