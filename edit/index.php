<?php
include "../session.php";
?>
<!DOCTYPE html>
    <head>
        <title>BCX</title>
        <?php
            include "../includes/header.php";
            include "../class/logic.php";
            $Logic = new Logic();
            if(!isset($_GET['user_id'])){
                echo "<div class='container'><div class='row w-100 align-items-center'><div class='col-lg-4'>
                <div class='alert alert-danger'>There was a technical error.</div>
                </div></div></div>";
              exit();  
            }
            $user_id = $_GET['user_id'];
        ?>
    </head>
    <body>
        <div class="container mb-5">
            <div class="row">
                
            <div class="col-lg-4"><h5><b>Edit User</b></h5></div>
            </div>
            <div class="row w-100 align-items-center">
                <div class="col-lg-12">
                    
                <form class="form-horizontal" role="form" method="post" id="form_update_user">
                    <?php $Logic->EditHTML($user_id);?>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div id="response"></div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="../js/function.js"></script>