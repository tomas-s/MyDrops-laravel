<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Sensor;
use App\Http\Controllers\UserSensorController;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Session\Flash;
use Input;
use Illuminate\Support\Facades\Redirect;
use Alert;

class MyDropsController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (Auth::user()->confirmed) {
            return view('mydrops', ['sensors' => UserSensorController::index(Auth::user()->id)]);
        } else {
            $user = Auth::user();
            if ($user->confirmation_code == null) {
                $confirmation_code = str_random(15);
                $user->confirmation_code = $confirmation_code;
                $user->save();

                $this->sendConfirmationEmail();
            }
            return view('confirmEmail');
        }
    }

    public function confirm($confirm_code) {
        $user = Auth::user();
        if ($user->confirmation_code == $confirm_code){
            $user->confirmed = 1;
            $user->save();
            return $this->index();
        } else {
            return view('welcome');
        }
    }
    
    public function sendConfirmationEmail (){
        $user = Auth::user();

    //test
    echo $user;



        /*Mail::send('emails.verify', ['user' => $user], function($message) use ($user) {
                    $message->to($user->email, $user->name)
                            ->subject('Verify your email address');
                });
        Alert::success('Success', 'Email was send');*/
        Mail::send('emails.verify', ["user" => $user->name, "confirmation_code" => $user->confirmation_code], function ($message) {
            //$message->from('us@example.com', 'Laravel');
            $user = Auth::user();
            $message->to($user->email, $user->name)->subject("Activate account!");
        });
        Alert::success('Success', 'Email was send');
        /*return view('confirmEmail');*/

    }

}
