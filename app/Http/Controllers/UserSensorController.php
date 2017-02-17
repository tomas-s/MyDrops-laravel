<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sensor;
use DB;
use App\User;

class UserSensorController extends Controller {
    /*
     * Returns all sensors for selected user
     * 
     * $userEmail email of selected user
     */

    public static function index($user_id) {
        /*$user = User::where("id", $user_id)->first();
        if (isset($user)) {
            return Sensor::where("user", $user->email)->get();
        } else {
            return array();
        }*/
        return Sensor::where('user_id',$user_id)->get();
    }

    /*
     * Returns selected sensor for selected user
     * 
     * $userEmail email of selected user
     * $sensorID ID of selected sensor
     */

    public static function show($user_id, $sensor_id) {
        $result = [];
        foreach (UserSensorController::index($user_id) as $sensor) {
            if ($sensor->sensorid == $sensor_id) {
                array_push($result, $sensor);
            }
        }
        return $result;
    }

}
