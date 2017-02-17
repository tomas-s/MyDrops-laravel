<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sensor;
use Illuminate\Auth\Access\Response;
use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\NotificationController;

class SensorController extends Controller {

    public static function index() {
        return Sensor::all();
    }

    public static function show($sensor_id) {
        return Sensor::where("sensor_id",$sensor_id)->get();
    }

    public static function createSensor(Request $request) {
        $sensor = new Sensor;
        $sensor->sensor_id = $request->input('DeviceID');
        $sensor->state = $request->input('State');
        $sensor->user_id = $request->input('UserEmail');
        $sensor->battery = $request->input('BatteryLife');
        $sensor->save();
    }

    public static function updateSensor(Request $request) {
        Sensor::where('sensor_id',$request->input('DeviceID'))
                ->update(['battery' => $request->input('BatteryLife'),
                          'state' => $request->input('State')]);
        
        $sensor = Sensor::where('sensor_id',$request->input('DeviceID'))->first();
        if ($request->input('State') == '2'){
            
            if ($sensor->call_enabled == 1){
                NotificationController::notify_user($sensor, 'call', 'water_detected');
            }
            
            if ($sensor->text_enabled == 1){
                NotificationController::notify_user($sensor, 'text', 'water_detected');
            }
            
            if ($sensor->email_enabled == 1){
                NotificationController::notify_user($sensor, 'email', 'water_detected');
            }
        }
        
        if ($request->input('BatteryLife') < 10){
            
            if ($sensor->call_enabled == 1){
                NotificationController::notify_user($sensor, 'call', 'low_battery');
            }
            
            if ($sensor->text_enabled == 1){
                NotificationController::notify_user($sensor, 'text', 'low_battery');
            }
            
            if ($sensor->email_enabled == 1){
                NotificationController::notify_user($sensor, 'email', 'low_battery');
            }
        }
        
    }
    
    public function formUpdateSensor(Request $request) {
    

        $sensor =  Sensor::where('sensor_id',$request->input('sensor_id'))->first();
        if ($sensor->user_id =!Auth::user()->id){
            return "Not Your Sensor!";
        }
        
        
        $s = Sensor::where('sensor_id',$request->input('sensor_id'));
        $s->update(['location' => $request->input('location'),
                    'name' => $request->input('name'),
                    'description' => $request->input('description')]);
        
        if ($request->input('phone') != ""){
            $s->update(['phone_number' => $request->input('phone')]);
        }
                
        if($request->input('call') == 'call'){
            $s->update(['call_enabled' => 1]);
        } else {
            $s->update(['call_enabled' => 0]);
        }
        
        if($request->input('text') == 'text'){
            $s->update(['text_enabled' => 1]);
        } else {
            $s->update(['text_enabled' => 0]);
        }
        
        if($request->input('email') == 'email'){
            $s->update(['email_enabled' => 1]);
        } else {
            $s->update(['email_enabled' => 0]);
        }
        
        
        return Redirect::to('/mydrops');
    
    }
    
    public static function destroy($sensorid){
        DB::delete('delete from sensors where sensorid = ?', $sensorid);
    }

}
