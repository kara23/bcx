<!DOCTYPE html>
    <head>
        <title>BCX</title>
        <?php
            include "../includes/header.php";
        ?>
    </head>
    <body>
        <div class="container mb-5">
            <form class="form-horizontal" role="form" method="post" id="login_user">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                            <label for="username" class="form-label">Username</label><br/>
                            <input type="text" class="form-control" placeholder="Enter username" id="username" name="username" /><br/>
                            <label for="password" class="form-label">Password</label><br/>
                            <input type="password" class="form-control" placeholder="Enter password" id="password" name="password" /><br/>
                            <div id="response"></div>
                            <input type="hidden" name="q" value='login_user' />
                            <button type="submit" class="btn btn-primary">Log in</button>  
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<script src="../js/function.js"></script>