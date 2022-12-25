$(document).ready(function (){
    $("#movie-list").on("click", function(){
        getAllMovies();
    });

    $("#btn-add-new").on("click", function(){
        $(".modal-title").html("Add movie");
        $("#table-manager").modal("show");
    });

    $("#table-manager").on("hidden.bs.modal", function(){
        $("#show-content").fadeIn();
        $("#edit-content").fadeIn();
        $("#name").val("");
        $("#language").val("");
        $("#btn-manage")
            .attr("value", "Add New")
            .attr("onclick", "manageData('addNew')")
            .fadeIn();

    });

});

function manageData(key, movieId=0){
    var name=$("#name").val();
    var language=$("#language").val();
    var year=$("#year").val();
    var runningTime=$("#runTime").val();
    var select=document.getElementById("select");
    var selectedValue = select.options[select.selectedIndex].value;

    if(
        isNotEmpty($("#name")) &&
        isNotEmpty($("#language")) &&
        isNotEmpty($("#year")) &&
        isNotEmpty($("#runTime"))
    ){
        $.ajax({
            url: "handler.php",
            method: "POST",
            dataType: "text",
            data: {
                key: key,
                movieId: movieId,
                name: name,
                language: language,
                year: year,
                runningTime: runningTime,
                selectedValue: selectedValue,
            },
            success: function(response){
                if(response !="success")alert(response);
                else{
                    getAllMovies();
                    location.reload();
                    $("#name").val("");
                    $("#language").val("");
                    $("#year").val("");
                    $("#runTime").val(0);
                    $("#table-manager").modal("hide");
                    $("#btn-manage")
                        .attr("value", "Add")
                        .attr("onclick", "manageData('addNew')");
                }
            },
        });
    }
}

function isNotEmpty(element){
    if(element.val() === ""){
        element.css("border", "1px solid red");
        return false;
    }
    else{
        element.css("border", "");
    }
    return true;
}


function getAllMovies(){
    $.ajax({
        url: "handler.php",
        method: "POST",
        dataType: "text",
        data: {
            key: "getAllMovies",
        },
        success: function(response){
            if(response == "success"){
                console.log("success");
            }
        },
    });
}

function viewOrEdit(movieId, type){
    $.ajax({
        url: "handler.php",
        method: "POST",
        dataType: "json",
        data: {
            key: "getMovieById",
            movieId: movieId,
        },
        success: function(response){
            var select = document.getElementById("select");
            if(type == "view"){
                $("#edit-content").css("display", "none");
                $("#show-content").fadeIn();
                $("#year-view").html(response.year);
                $("#runTime-view").html(response.runningTime);
                $("#category-view").html(select.options[response.category].text);
                $("#btn-manage").css("display", "none");
                $("#btn-close-view").fadeIn();
            }
            else{
                $("#edit-content").fadeIn();
                $("#name").val(response.name);
                $("#language").val(response.language);
                $("#year").val(response.year);
                $("#runTime").val(response.runningTime);
                select.selectedIndex = response.category;
                $("#btn-close").fadeIn();
                $("#btn-manage")
                    .attr("value", "Edit")
                    .attr("onclick", `manageData('update', ${movieId})`);
            }

            $(".modal-title").html(response.name);
            $("#table-manager").modal("show");
        },
    });
}

function deleteMovie(movieId){
    swal({
        title: "Are you sure you want to delete this movie?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete)=>{
        if(willDelete){
            $.ajax({
                url: "handler.php", 
                method: "POST", 
                dataType: "json", 
                data:{
                    key:"deleteMovie",
                    movieId: movieId,
                },
                success: function(response){
                    if(response.success){
                        toastr.success(response.message);
                        setTimeout(()=>{
                            getAllMovies();
                            location.reload();
                        },2000);
                    }else{
                        toastr.error(response.message);
                    }
                },
            });
        }   
    });
}

function sortDescending(){
    var table, rows, switching, i, front, back, shouldSwitch;
    table = document.getElementById("category-table");
    switching=true;

    while(switching){
        switching=false;
        rows=table.rows;
        for(i=1; i<rows.length-1;i++){
            shouldSwitch = false;
            front = rows[i].getElementsByTagName("td")[1];
            back = rows[i + 1].getElementsByTagName("td")[1];

            if(+front.innerHTML - +back.innerHTML<0){
                shouldSwitch = true;
                break;
            }
        }
        if(shouldSwitch){
            rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
            switching=true;
        }
    }
}


