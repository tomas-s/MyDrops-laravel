<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sensor;
use App\Notification;
use DateTime;
use Twilio;
use App\User;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller {

    public static function get_notification($sensor, $method, $reason) {
        $data = ['sensor_id' => $sensor->sensor_id,
            'contact_method' => $method,
            'reason' => $reason];
        return Notification::firstOrCreate($data);
    }

    public static function notify_user($sensor, $method, $reason) {
        $notification = NotificationController::get_notification($sensor, $method, $reason);

        $date = new DateTime;
        $date->modify('-30 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        if ($notification->last_notification == null || $formatted_date >= $notification->last_notification) {


            if ($method == 'call') {
                NotificationController::make_call($sensor, $reason);
            }

            if ($method == 'text') {
                NotificationController::send_text($sensor, $reason);
            }

            if ($method == 'email') {
                NotificationController::send_email($sensor, $reason);
            }

            $newDate = new DateTime;
            $formatted_newDate = $newDate->format('Y-m-d H:i:s');

            Notification::where('id', $notification->id)->update(['last_notification' => $formatted_newDate]);
        }
    }

    public static function make_call($sensor, $reason) {
        echo " call ";

        switch ($reason) {
            case 'water_detected':
                Twilio::call($sensor->phone_number, function ($message) use ($sensor) {
                    $message->say("Hello Your sensor " . $sensor->name . " Sensor id: " . $sensor->sensor_id . " detected water!");
                });
                break;
            case 'low_battery':
                Twilio::call($sensor->phone_number, function ($message) use ($sensor) {
                    $message->say("Battery of your sensor " . $sensor->name . " Sensor id: " . $sensor->sensor_id . " is below 10%!");
                });
                break;
        }
    }

    public static function send_text($sensor, $reason) {
        echo " text ";

        switch ($reason) {
            case 'water_detected' :
                $message = "Your sensor " . $sensor->name . " Sensor id: " . $sensor->sensor_id . " detected water!";
                break;
            case 'low_battery' :
                $message = "Battery of your sensor " . $sensor->name . " Sensor id: " . $sensor->sensor_id . " is below 10%!";
                break;
        }
        Twilio::message($sensor->phone_number, $message);
    }

    public static function send_email($sensor, $reason) {
        echo " email ";

        $user = User::where('id', $sensor->user_id)->first();

        switch ($reason) {
            case 'water_detected' :
                Mail::send('emails.waterDetected', ['user' => $user, 'sensor' => $sensor], function ($message) use ($user, $sensor) {
                    $message->to($user->email, $user->name)->subject('Water was detected!');
                });
                break;
            case 'low_battery' :
                Mail::send('emails.lowBattery', ['user' => $user, 'sensor' => $sensor], function ($message) use ($user, $sensor) {
                    $message->to($user->email, $user->name)->subject('Low battery!');
                });
                break;
            case 'lost_contact' :
                Mail::send('emails.lostContact', ['user' => $user, 'sensor' => $sensor], function ($message) use ($user, $sensor) {
                    $message->to($user->email, $user->name)->subject('Contact lost!');
                });
                break;
        }
    }

    public function test() {
        $sensor = New Sensor;
        $sensor->sensor_id = "07-B4-11-CA-5F-2";
        $sensor->state = 2;
        $sensor->phone_number = "+420775972734";
        $sensor->user_id = "13";
        $sensor->name = "mySensor";
        NotificationController::notify_user($sensor, "call", "water_detected");
        //NotificationController::notify_user($sensor, "text", "low_battery");
        //NotificationController::notify_user($sensor, "email", "low_battery");
    }

}
