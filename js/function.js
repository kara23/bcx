$("#user_roles").change(function(){
    $("#priv").show();
    if($(this).val() == "admin"){
        $("#show_user_rights").html("Full rights");
    }
    else if($(this).val() == "support"){
        $("#show_user_rights").html("View and edit users");
    }

    else if($(this).val() == "manager"){
        $("#show_user_rights").html("Create user and  view user");
    }

    else if($(this).val() == "user"){
        $("#show_user_rights").html("View and edit own details only");
    }

    else if($(this).val() == "custom"){
        $("#show_user_rights").html("---");
    }
   
});


$("#login_user").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '../class/logic.php',
        type: 'POST',
        data: $("#login_user").serialize(),
        success: function(data){
            $("#response").show();
            $("#response").html(data);
        }
    })
});

$("#form_add_user").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: 'class/logic.php',
        type: 'POST',
        data: $("#form_add_user").serialize(),
        success: function(data){
            $("#response").show();
            $("#response").html(data);
        }
    })
});


$("#form_update_user").submit(function(e){
    e.preventDefault();
    $.ajax({
        url: '../class/logic.php',
        type: 'POST',
        data: $("#form_update_user").serialize(),
        success: function(data){
            $("#response").show();
            $("#response").html(data);
        },
        error: function(error) {
            // handle failure
            console.log(error);
        }
    })
});

function del(user_id) {
    $.ajax({
        url: '../class/logic.php',
        type: 'PUT',
        data: "user_id="+user_id,
        success: function(data){
            $("#response").show();
            $("#response").html(data);
            $(".row_"+user_id).fadeOut();
        },
        error: function(error) {
            // handle failure
            console.log(error);
        }
    })
   
}