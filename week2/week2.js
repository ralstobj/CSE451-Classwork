//Bailey Ralston
//CSE 451
//Javascript Week 2
//02/5/2019
$(document).ready(function(){
    $.ajax({
        type: 'GET',
        url: 'http://campbest.451.csi.miamioh.edu/cse451-campbest-web-public/week2/week2-rest.php/api/v1/info',
        success: function(data){
            for (i=0; i < data.keys.length; i++){
                var specificKey = data.keys[i];
                getValue(specificKey);
                var tr = document.createElement("tr");
                $(tr).attr('id', 'row'+i)
                var td1 = document.createElement("td");
                $(td1).text(specificKey);
                $(tr).append(td1);
                $("#keyTable").append(tr);
                getValue(specificKey, i);
            }

        },
        error: function( req, status, err ) {
            console.log( 'something went wrong ', status, err );
        }
    });
});

function getValue(keyRecieved, i){
    $.ajax({
        type: 'POST',
        url: 'http://campbest.451.csi.miamioh.edu/cse451-campbest-web-public/week2/week2-rest.php/api/v1/info',
        contentType: 'application/json',
        data: JSON.stringify({key:keyRecieved}),
        success: function(data){
            console.log(data.status);
            if(data.status == "OK"){
                value = data.value;
                var td2 = document.createElement("td");
                $(td2).text(value);
                $("#row"+i).append(td2);
            }else{
                console.log('Data status not okay');
            }
        },
        error: function( req, status, err ) {
            console.log( 'something went wrong ', status, err );
        }
});

}