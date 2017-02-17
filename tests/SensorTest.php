<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Http\Controllers\SensorController;
use App\Sensor;


class SensorTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateSensor(){
        $sensorid = 123;
        $this->post("/newdata", ['UserEmail' => 'user1@go.com', 'DeviceID' => $sensorid, 'State' => 1 , 'BatteryLife' => 98 ]);
        $sensors = Sensor::all();
        $sensor = null;
        foreach ($sensors as $sensor1) {
            if ($sensor1->sensorid == $sensorid) {
                $sensor = $sensor1;
            }
        }
        echo $sensor;
        $this->assertEquals($sensor->user, 'user1@go.com');
        $this->assertTrue(true);
    }
    
    public function testJoj() {
        $response = $this->call("POST","/newdata", ['UserEmail' => 'user1@go.com', 'DeviceID' => 123, 'State' => 1 , 'BatteryLife' => 98 ]);
        echo $response;
        $this->assertTrue(true);
    }
}
