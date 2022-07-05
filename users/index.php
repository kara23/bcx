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
        ?>
    </head>
    <body>
        <div class="container mb-5">
            <div class="row">
                
            <div class="col-lg-4"><h5><b>Users</b></h5></div>
            </div>
            <div class="row w-100 align-items-center">
                <div class="col-12">
                   <?php $Logic->Users();?>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="../js/function.js"></script>