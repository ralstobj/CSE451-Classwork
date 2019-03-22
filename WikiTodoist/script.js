var projectid;
$(document).ready(function() {
    getData(token);

$("#refresh").click(function(){
	$("#unorderedList").empty();
        getData(token);
});
$("#addTask").submit(function(e){
	e.preventDefault();
	addNewTask($("#taskInfo").val(),token);
});
});
function getData(token){
    $.ajax({
        type: 'GET',
        headers:{"Authorization": "Bearer " + token},
        url: 'https://beta.todoist.com/API/v8/projects',
        success: function(data){
            var flag = 0;
            for(var i = 0; i < data.length; i++) {
                var projects = data[i];
                if(projects.name == "cse451Project1"){
                    flag = projects.id;
                }
            }
            if(flag != 0){
                getTasks(token, flag);
            }else{
                createNewProject(token);
            }
        },
        error: function( req, status, err ) {
            console.log( 'something went wrong ', status, err );
        }
    });
}
    function getTasks(token, id){
	projectid = id;
        $.ajax({
            type: 'GET',
            headers:{"Authorization": "Bearer " + token},
            url: 'https://beta.todoist.com/API/v8/tasks',
            success: function(data){
                for(var i = 0; i < data.length; i++) {
                    var projects = data[i];
                    if(projects.project_id == id){
                        var task = projects.content;
                        var listItem = document.createElement("li");
			$(listItem).text(''+task+'');
                        $("#unorderedList").append(listItem);
                    }
                }
            },
            error: function( req, status, err ) {
                console.log( 'something went wrong ', status, err );
            }
    });
}
function createNewProject(token){
    var data = {};
    data.name = "cse451Project1";
    $.ajax({
        type: 'POST',
        headers:{"Authorization": "Bearer " + token, "Content-Type": "application/json"},
        url: 'https://beta.todoist.com/API/v8/projects',
        data: JSON.stringify(data),
        success: function(data){
		projectid = data.id; 
        },
        error: function( req, status, err ) {
            console.log( 'something went wrong ', status, err );
        }
}); 
}
function addNewTask(content, token){
    var data = {};
    data.content = content;
    data.project_id = projectid;
    $.ajax({
        type: 'POST',
        headers:{"Authorization": "Bearer " + token, "Content-Type":"application/json"},
        url: 'https://beta.todoist.com/API/v8/tasks',
        data: JSON.stringify(data),
        success: function(data){
	    $("#unorderedList").empty();
            getTasks(token, projectid);
        },
        error: function( req, status, err ) {
            console.log( 'something went wrong ', status, err );
        }
    });
}

