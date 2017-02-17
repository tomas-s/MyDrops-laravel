<?php

namespace App\Http\Controllers;

//use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\SensorController;
use DB;
use App\Sensor;
use Auth;
use App\Http\Controllers\MyDropsController;

class DataController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Post data
     *
     * @return void
     */
    public function postData(Request $request) {

        
        if(!(DataController::validateData($request))){
            return "Invalid data";
        }
        
         
         
        
        $sensorId = $request->input('DeviceID');
        $results = DB::select('select * from sensors where sensor_id = ?', array($sensorId));

        if (count($results) == 0) {
            SensorController::createSensor($request);
            return "Device was created";
        } else {
            SensorController::updateSensor($request);
            return "Device was updated";
        } 
    }
    
    public static function validateData(Request $request) {
        if ($request->input('BatteryLife') < 0 || $request->input('BatteryLife') > 100){
            return false;
        }
        if ($request->input('State') < 1 || $request->input('State') > 2){
            return false;
        }
        return true;
    }
    
}
