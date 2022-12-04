$(document).ready(function(){
    $("#btn-login").on("click", function (e){
        e.preventDefault();
        const username = $("#username").val();
        const password = $("#password").val();

        if(username === "" || password === ""){
            alert("Please enter your email and password.");
        }else{
            $.ajax({
                url: "handler.php",
                method: "POST",
                dataType: "text",
                data: {
                    key: "login",
                    username: username,
                    password: password,
                },
                success: function (response) {
                    $("#response").html(response);
                    if(response === "success"){
                        $("#response").addClass("text-success");
                        window.location = "home.php";
                    }else{
                        $("#response").addClass("text-danger");
                    }
                },
            });
        }
    });
});