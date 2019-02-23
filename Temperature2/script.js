$(document).ready(function(){
    $("#alert").hide();
});


function getTemperature() {
    var dataFromForm = {};
	$("#temp").remove();
	var cityId = $('#city').find(":selected").val();
	dataFromForm.cityId = cityId;
    $.ajax({
            type: 'POST',
            url: 'rest.php/v1/temperature',
            contentType: 'application/json',
            data: JSON.stringify(dataFromForm),
            success: function(data){
                console.log(data);
                if(data.status == "OK"){
                $("#beforeTemp").after("<h3 id='temp'> The temperature of " + $("#city").find(":selected").text() + " is " + data.temp+"°F " + " at " + Date(data.updateTime*1000)  + "</h3>");
                    $("#alert").hide();
                }else{
                    $("#alert").show();
                }
            },
            error: function( req, status, err ) {
    		console.log( 'something went wrong ', status, err );
                $("#alert").show();
            }
    });
}

