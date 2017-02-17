
// Validating Empty Field
function check_empty() {
    if (document.getElementById('name').value == "" ) {
        alert("Name can not be empy");
        return;
    }
    
    if ((document.getElementById("call").checked==true || document.getElementById("text").checked==true ) 
            && document.getElementById("phone").value == ""){
        alert("You have to set up your phone number");
        return;
    }
    document.getElementById('pop_up_form').submit();  
}

//Function To Display Popup
function show_pop_up(sensor) {
    document.getElementById('grey_background').style.display = "block";
    document.getElementById('pop_up_form').style.display = "block";
    document.getElementById("sensor_name").innerHTML = "Configure your sensor: " + sensor.name;
    document.getElementById("sensor_id").value = sensor.sensor_id;
    document.getElementById("description").innerHTML = sensor.description;
    document.getElementById("name").value = sensor.name;
    document.getElementById("phone").value = sensor.phone_number;
    if (sensor.call_enabled == 1) {
        document.getElementById("call").checked=true;
    } else {
        document.getElementById("call").checked=false;
    }
    if (sensor.text_enabled == 1) {
        document.getElementById("text").checked=true;
    } else {
        document.getElementById("text").checked=false;
    }
    if (sensor.email_enabled == 1) {
        document.getElementById("email").checked=true;
    } else {
        document.getElementById("email").checked=false;
    }
    set_select(sensor.location);
}
//Function to Hide Popup
function hide_pop_up(){
    document.getElementById('grey_background').style.display = "none";
    document.getElementById('pop_up_form').style.display = "none";
}

function OnDropDownChange(dropDown) {
    var selectedValue = dropDown.options[dropDown.selectedIndex].value;
    document.getElementById("locationImg").setAttribute("src","imgs/icon_"+selectedValue+".png");
    document.getElementById("name").value = selectedValue;
}

function set_select(location){
    var dropDown = document.getElementById("location_select");
    for (index = 0; index < dropDown.options.length; index++){
        var option = dropDown.options[index];
        if (location == option.value){
            option.setAttribute("selected","selected");
            document.getElementById("locationImg").setAttribute("src","imgs/icon_"+option.value+".png");
        } else {
            option.removeAttribute("selected");
        }
    }
    OnDropDownChange(dropDown);
}