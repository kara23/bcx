<?php
session_start();
$basename = basename($_SERVER['REQUEST_URI']);
if($basename !== 'bcx'){
$path = "../";
$url = "../";
} else{
$path = "";
$url = "";
}

?>
<link href="<?=$path;?>css/bootstrap/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="<?=$path;?>css/styles/style.css" rel="stylesheet" integrity="">
<script src="<?=$path;?>js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="<?=$path;?>js/jquery2.1.1.min.js"></script>

<nav class="navbar navbar-default navbar-fixed-top nav w-100 nav-border">
    <div class="container">
        <div class="row w-100">
            <?php if(isset($_SESSION['user'])){

                if($_SESSION['role'] == 'support' || $_SESSION['role'] == 'user'){

                    ?>
                    <div class="col-lg-4" id="add_user_tab">
                    
                        <label class="tabs-disabled text-right text-grey">Add User </label>
                    </div>
                    <?php

                } else{
                    ?>
                    <div class="col-lg-4" id="add_user_tab">
                    <a href='<?=$url;?>'>
                        <label class="tabs text-right">Add User</label>
                    </a>
                    </div>
                    <?php
                }
                ?>
                
            <div class="col-lg-4" id="list_user_tab">
                <a href='<?=$url;?>users'>
                    <label class="tabs text-center">View users</label>
                </a>
            </div>
            <div class="col-lg-4" id="list_user_tab">
                <a href='<?=$url;?>logout.php'>
                    <label class="tabs text-left">Log out</label>
                </a>
            </div>
            <?php
                }
                else{
                    ?>
                    <div class="col-lg-12" id="add_user_tab">
                <a href='<?=$url;?>login'>
                    <label class="tabs text-center">Log In</label>
                </a>
            </div>
            <?php
                };
            ?>
            
        </div>
    </div>
</nav>

<?php if(isset($_SESSION['user'])){
    ?>
    <div class="container">
    <div class="row">
        <div class="col-lg-12 text-center mb-4">
            Username: <b><?=$_SESSION['user'];?></b>
        </div>
    </div>
</div>
<?php
}
;?>
