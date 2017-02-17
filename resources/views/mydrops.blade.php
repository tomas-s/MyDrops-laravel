@extends('layouts.app')

@section('content')

<script src="js/pop_up_configuration.js"></script>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    
                    <ul class="sensors">
                    @foreach ($sensors as $sensor)
                    <li class="item" onclick="show_pop_up({{$sensor}})">
                        <h4 style="text-align: center;margin: 2% 0 0 0;">Sensor {{$sensor->name}}</h4>
                        <h6 style="text-align: center;margin: 0 0 0 0;">Sensor ID: {{$sensor->sensor_id}}</h6>

                        <div class="images">
                            
                        <!--Setting location img -->
                        @if ($sensor->location == "generic")
                            <img src="imgs/icon_generic.png"/>
                        @elseif ($sensor->location == "hot_tub")
                            <img src="imgs/icon_hot_tub.png"/>
                        @elseif ($sensor->location == "dishwasher")
                            <img src="imgs/icon_dishwasher.png"/>
                        @elseif ($sensor->location == "pool")
                            <img src="imgs/icon_pool.png"/>
                        @elseif ($sensor->location == "washing_machine")
                            <img src="imgs/icon_washing_machine.png"/>
                        @elseif ($sensor->location == "floor")
                            <img src="imgs/icon_floor.png"/>
                        @elseif ($sensor->location == "refrigerator")
                            <img src="imgs/icon_refrigerator.png"/>
                        @elseif ($sensor->location == "sink")
                            <img src="imgs/icon_sink.png"/>
                        @elseif ($sensor->location == "toilet")
                            <img src="imgs/icon_toilet.png"/>
                        @elseif ($sensor->location == "water_heater")
                            <img src="imgs/icon_water_heater.png"/>    
                        @endif
                        
                        <img src="imgs/divider.png"/>
                        
                        <!-- setting battery img -->
                        @if ($sensor->battery > 75)
                            <img src="imgs/battery_4_bars.png"/>
                        @elseif ($sensor->battery > 50)
                            <img src="imgs/battery_3_bars.png"/>
                        @elseif ($sensor->battery > 25)
                            <img src="imgs/battery_2_bars.png"/>
                        @elseif ($sensor->battery > 10)
                            <img src="imgs/battery_1_bar.png"/>
                        @else
                            <img src="imgs/battery_0_bars.png"/>
                        @endif
                        <div class="battery_percent">
                            {{$sensor->battery}}%
                        </div>
                        </div>
                        
                        <div class ="status">
                        @if ($sensor->state == 1)
                            <p>Water is not detected</p>
                            <img src="imgs/sm_icon_green.png"/>
                        @elseif ($sensor->state == 2)
                            <p>Water was detected!</p>
                            <img src="imgs/sm_icon_red.png"/>
                        @else
                            <p>Contact was lost.</p>
                            <img src="imgs/sm_icon_red.png"/>
                        @endif
                        </div>
                    </li>
                    @endforeach
                    </ul>
                  
                    
                    <div id="grey_background" onclick="hide_pop_up()"></div>
                    <!-- Popup Div Starts Here -->
                    <div id="popup">
                    <!-- Popup Form -->
                    <form action="{{ url('/changeSensorData') }}" id="pop_up_form" method="post" name="form">
                        <!--<img id="close" src="imgs/close_blue.png" onclick ="hide_pop_up()">-->
                        <h4 id="sensor_name">Configure your sensor </h4>
                        <h5>Location: </h5>
                        <div class="locationSelectDiv">
                            
                        <select id="location_select" name="location" onChange="OnDropDownChange(this);">
                            <option value="generic">generic</option>
                            <option value="pool">pool</option>
                            <option value="dishwasher">dishwasher</option>
                            <option value="refrigerator">refrigerator</option>
                            <option value="toilet">toilet</option>
                            <option value="sink">sink</option>
                            <option value="washing_machine">washing machine</option>
                            <option value="water_heater">water heater</option>
                            <option value="hot_tub">hot tub</option>
                            <option value="floor">floor</option>
                        </select>
                        <img id="locationImg" src="imgs/icon_generic.png"/>
                        </div>
                        
                        
   
                    <!--<input type="text" id="txtSelectedLocation" name="SelectedLocation" value="generic" />-->
                    
                    <h5>Name: </h5>
                    <input id="name" class="input-text" name="name" placeholder="Sensor Name" type="text">
                    
                    <h5>Description: </h5>
                    <textarea id="description" name="description" placeholder="Description"></textarea>
                    
                    <h5>Contact Settings: </h5>
                    <p>You will get contacted with notifications regarding water detection or
                        a sensor's battery dropping below 10% via email, text, and/or phone 
                        by completing the following information: </p>
                    
                    <!--<input id="phone" type="checkbox" name="Phone" value="phone">Phone<br>-->
                    <!--<input id="forAll" type="checkbox" name="forAll" value="forAll">Set for all sensors<br>-->

                    <input id="call" type="checkbox" name="call" value="call">Enable Call<br>
                    <input id="text" type="checkbox" name="text" value="text">Enable Text<br>
                    <input id="email" type="checkbox" name="email" value="email" style="margin-bottom: 20px;">Enable Email<br>
                    
                    <input id="phone" class="input-text" name="phone" placeholder="Phone Number" type="text">
  
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" id="sensor_id" name="sensor_id" value="" />
                    <a href="javascript:%20check_empty()" id="submit">Save</a>
                    </form>
                    </div>
                    <!-- Popup Div Ends Here -->
                    
                    
            </div>
        </div>
    </div>
</div>
</div>

@endsection
