<?php
include "session_home.php";
?>
<!DOCTYPE html>
    <head>
        <title>BCX</title>
        <?php
            include "./includes/header.php";
        ?>
    </head>
    <body>
        <div class="container mb-5">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-4 text-center"><h5><b>Add User</b></h5></div>
            </div>

            <form class="form-horizontal" role="form" method="post" id="form_add_user">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                            <label for="name" class="form-label">Name</label><br/>
                            <input type="text" class="form-control" placeholder="Name" id="name" name="name" /><br/>
                            <label for="surname" class="form-label">Surname</label><br/>
                            <input type="text" class="form-control" placeholder="Surname" id="surname" name="surname" /><br/>
                            <label for="email" class="form-label">E-mail</label><br/>
                            <input type="text" class="form-control" placeholder="e-mail" id="email" name="email" /><br/>
                            <label for="cell" class="form-label">Cell number</label><br/>
                            <input type="text" class="form-control" placeholder="cell" id="cell" name="cell" /><br/>
                            <label for="username" class="form-label">Username</label><br/>
                            <input type="text" class="form-control" placeholder="username" id="username" name="username" /><br/>
                            <label for="password" class="form-label">Password</label><br/>
                            <input type="password" class="form-control" placeholder="password" id="password" name="password" /><br/>
                            
                    </div>

                    <div class="col-lg-4">
                            <label for="address" class="form-label">Address</label><br/>
                            <textarea class="form-control" name="address" rows="5" placeholder="Address" id="address" name="address"></textarea><br/>
                            <label for="job-title" class="form-label">Job Title</label><br/>
                            <input type="text" class="form-control" placeholder="job title" id="job-title" name="job_title"/><br/>
                            
                            <label for="user_roles" class="form-label">User roles</label><br/>
                            <select class="form-control" name="user_roles" id="user_roles">
                                <option value="">Select a role</option>
                                <option value="admin">Admin</option>
                                <option value="support">Support</option>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
                                <option value="custom">Custom</option>
                            </select><br/> 
                            <div id="priv"><b>Privileges:</b> <span id="show_user_rights" class="text-dark-orange"></span></div>
                    </div>
                    <div class="col-lg-8">
                        <div id="response"></div>
                        <input type="hidden" name="q" value='add_user' />
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
<script src="./js/function.js"></script>