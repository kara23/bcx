<?php
session_start();
include "../db.php";
// declare class
class Logic {
    public function AddUser($name, $surname, $email, $cell, $username, $password, $address, $job_title, $user_id, $user_roles): void {
        global $connect;
        $dtcreated = date('Y-m-d H:i:s');
        // Validate password strength
        $ucase = preg_match('@[A-Z]@', $password);
        $lcase = preg_match('@[a-z]@', $password);
        $num   = preg_match('@[0-9]@', $password);
        $special_chars = preg_match('@[^\w]@', $password);

        // check if all requied fields are filled
        if( empty(trim($name)) || empty(trim($surname)) || empty(trim($email)) || empty(trim($username))){
            echo "<span class='text-red'>All fields are required, only the address and job title are optional.</span><br/>";
            return;
        }

        // validate email address
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<span class='text-red'>Email format is invalid.</span><br/>";
            return;
        }

        // check if password length is 8 or long in character.
        if(empty(trim($cell)) || strlen($cell) < 10) {
            echo "<span class='text-red'>Invalid cell number</span><br/>";
            return;
        }


        // check if password length is 8 or long in character.
        if(strlen($password) < 8 && $user_id <= 0) {
            echo "<span class='text-red'>Password should at least be 8 characters long.</span><br/>";
            return;
        }

        // check if password has uppercase letter
        if(!$ucase && $user_id <= 0){
            echo "<span class='text-red'>Password should at least include one uppercase letter.</span><br/>";
            return;
        }

        // check if password has lower case letter
        if(!$lcase && $user_id <= 0){
            echo "<span class='text-red'>Password should at least include one lowercase letter.</span><br/>";
            return;
        }

        // check if password has a number
        if(!$num && $user_id <= 0){
            echo "<span class='text-red'>Password should at least include one number.</span><br/>";
            return;
        }

        // check if password has special character
        if(!$special_chars && $user_id <= 0){
            echo "<span class='text-red'>Password should at least include one special character.</span><br/>";
            return;
        }

        if( empty(trim($user_roles)) && $user_id <= 0 ){
            echo "<span class='text-red'>Select user role.</span><br/>";
            return;
        }

        // set rights depending on the role
        if($user_roles == 'admin'){
            $rights = "full rights";
        }
        elseif($user_roles == "support"){
            $rights = "view and edit users";
        }

        elseif($user_roles == "manager"){
            $rights = "create user, view user";
        }

        elseif($user_roles == "user"){
            $rights = "view and edit own details only";
        }

        elseif($user_roles == "custom"){
            $rights = "";
        }


        // check if the username already exists
        $user = strtolower($username);
        $sql = "select * from users where lower(username)=\"$user\"";
        
        // check if the above statement is true
        if($sql == true){
            $execute = $connect->query($sql);

            // if the query 0; then insert new user
            if($execute->num_rows == 0){

                // unencrypted password;
                $pass = $password;

                // encrypt password;
                $password = md5($password);

                if($user_id > 0) {
                    // because this is an update; the incoming password can be empty and still use the existing one.
                    if(empty(trim($pass))){
                        $column = "";
                    } else{
                        $column = "password=\"$password\",";
                    }
                    // update user details
                    $insert = "update users set name=\"$name\", surname=\"$surname\", email=\"$email\", cell=\"$cell\", $column address=\"$address\", job_title=\"$job_title\" where id=$user_id";
                    
                    // update the user role
                    $update_roles = "update user_roles set role=\"$user_roles\", rights=\"$rights\" where user_id=$user_id";

                    // check if the above statement is true
                    if($update_roles == true){

                        // if new role is not set then don't execute the update, leave the existing role
                        if( !empty(trim($user_roles)) || trim($user_roles) !== ""){
                            $connect->query($update_roles);
                            // $_SESSION['role'] = $user_roles;
                        }
                    }
                } else{
                    // insert new user
                    $insert = "insert into users(id, name, surname, email, cell, username, password, address, job_title, deleted, dtcreated) values(DEFAULT, \"$name\", \"$surname\", \"$email\", \"$cell\", \"$username\", \"$password\", \"$address\", \"$job_title\", 'no', '$dtcreated')";
                }
                
                // check if the above statement is true
                if($insert == true){
                    $connect->query($insert);
                    if($user_id > 0){
                        echo "<span class='text-green'>User details updated<br/><b>NB:</b> If you updated the user role, login again for new rights to take effect.</span><br/>";
                    } else{
                        echo "<span class='text-green'>User successfully added</span><br/>";
                    }

                    if($user_id <= 0){
                                // get user_id of the new user
                    $select = "select id as user_id from users where username=\"$username\"";
                    // check if the above statement is true
                    if($select == true){
                        $execute = $connect->query($select);
                        if($execute->num_rows == 1){
                            $fetch = $execute->fetch_assoc();
                            $userid = $fetch['user_id'];
                             // insert roles for the new user
                            $insert_roles = "insert into user_roles(id, user_id, role, rights, dtcreated) values(DEFAULT, \"$userid\", \"$user_roles\", \"$rights\", '$dtcreated')";
                            if($insert_roles == true){
                                $connect->query($insert_roles);
                                echo "<span class='text-green'>User role added</span><br/>";
                            }
                        } else{
                            echo "<span class='text-red'><b>User role:</b> There's a technical error, try again $user_roles</span><br/>";
                            }
                        }
                    }
                

                } else{
                    echo "<span class='text-red'>There was a technical error, try again</span>";
                }
                return;
            } else{
                // log error message if username already exists
                echo "<span class='text-red'>The username (".$username.") already exists</span>";
                return;
            }
        } else{
            // log technical error message incase something goes wrong
            echo "<span class='text-red'>There was a technical error, try again</span>";
            return;
        }
    }



    // declare user list function
    public function Users(){
        global $connect;
        $user = $_SESSION['user'];
        if($_SESSION['role'] == 'user'){
            $query = " and username=\"$user\"";
        }
        $select = "
        select *, users.id as user_id, role, rights from users 
        inner join user_roles on (user_roles.user_id=users.id)
        where deleted='no' $query order by users.id desc
        ";
        if($select == true){
            $execute = $connect->query($select);
            if($execute->num_rows > 0){
                ?>
                <table width='100%' class='table table-striped'>
                    <tr>
                        <th>Name and Surname</th>
                        <th>Email address</th>
                        <th>Cell</th>
                        <th>Username</th>
                        <th>Address</th>
                        <th>Job title</th>
                        <th>User role</th>
                        <th>Rights</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                <?php
                while($fetch = $execute->fetch_assoc()){
                    $full_name = ucwords($fetch['name']).' '.ucwords($fetch['surname']);
                    $email = $fetch['email'];
                    $cell = $fetch['cell'];
                    $username = $fetch['username'];
                    $address = $fetch['address'];
                    $job_title = $fetch['job_title'];
                    $user_id = $fetch['user_id'];
                    $role = ucfirst($fetch['role']);
                    $rights = ucfirst($fetch['rights']);
                    ?>
                    <tr class="row_<?=$user_id;?>">
                        <td><?=$full_name;?></td>
                        <td><?=$email;?></td>
                        <td><?=$cell;?></td>
                        <td><?=$username;?></td>
                        <td><?=$address != '' ? $address : "<span class='text-red'>N/A</span>";?></td>
                        <td><?=$job_title != '' ? $job_title : "<span class='text-red'>N/A</span>";?></td>
                        <td><?=$role;?></td>
                        <td><?=$rights;?></td>
                        <td><?=$_SESSION['role'] == 'manager' ? '<span class="text-grey">Edit</span>' : "<a href='../edit?user_id=$user_id' class='text-blue anchor'>Edit</a>";?></td>
                        <td><?=$_SESSION['role'] == 'manager' || $_SESSION['role'] == 'support' || $_SESSION['role'] == 'user' ? '<span class="text-grey">Delete</span>' : "<span onclick='del($user_id)' class='text-red anchor'>Delete</span>";?></td>
         
                    </tr>
                    <?php
                }

              ?>
                </table>
              <?php
            } else{
                echo "<span class='text-red'>Users not found</span>";  
            }
        } else{
            echo "<span class='text-red'>There was a technical error</span>";  
        }
        
    }

    // declare html fields for edit
    public function EditHTML($user_id){
        global $connect;
        $select = "
        select *, users.id as user_id from users 
        inner join user_roles on (user_roles.user_id = users.id)
        where users.id=".$user_id;
        if($select == true){
            $execute = $connect->query($select);
            if($execute->num_rows > 0){
                ?>
                <table width='100%' class='table table-striped'>
                    <tr>
                        <th width="120">Name</th>
                        <th width="120">Surname</th>
                        <th>Email address</th>
                        <th width="120">Cell</th>
                        <th width="120">Password</th>
                        <th>Address</th>
                        <th width="120">Job title</th>
                        <th>Current role</th>
                        <th>Update role</th>
                    </tr>
                <?php
                $fetch = $execute->fetch_assoc();
                    $email = $fetch['email'];
                    $cell = $fetch['cell'];
                    $address = $fetch['address'];
                    $job_title = $fetch['job_title'];
                    $user_id = $fetch['user_id'];
                    $role = ucfirst($fetch['role']);
                    ?>
                    <tr>
                    <td><input type="text" class="form-control" placeholder="name" id="name" name="name" value="<?=$fetch['name'];?>" /></td>
                    <td><input type="text" class="form-control" placeholder="surname" id="surname" name="surname" value="<?=$fetch['surname'];?>" /></td>
                        <td><input type="text" class="form-control" placeholder="e-mail" id="email" name="email" value="<?=$email;?>" /><br/></td>
                        <td><input type="text" class="form-control" placeholder="cell" id="cell" name="cell" value="<?=$cell;?>" /></td>
                        <td><input type="password" class="form-control" placeholder="password" id="password" name="password" /></td>
                        <td><input type="text" class="form-control" placeholder="address" id="address" name="address" value="<?=$address;?>" /></td>
                        <td><input type="text" class="form-control" placeholder="job title" id="job_title" name="job_title" value="<?=$job_title;?>" /></td>
                        <td valign="top"><label class="text-dark-orange"><?=$role;?></label></td>
                        <td>
                        <select class="form-control" name="user_roles" id="user_roles">
                                <option value="">Select a role</option>
                                <?=$_SESSION['role'] !== 'admin' ? '' : '<option value="admin">Admin</option>';?>
                                <option value="support">Support</option>
                                <option value="manager">Manager</option>
                                <option value="user">User</option>
                            </select>
                        </td>
                        
                    </tr>
                    <tr>
                    <td colspan="10"><button type="submit" class="btn btn-primary">Save</button></td>
                    </tr>
                    <?php
                

              ?>
                </table>
                <input type="hidden" name="user_id" value='<?=$user_id;?>' />
                <input type="hidden" name="q" value='update_user' />
                <!-- username placeholder -->
                <input type="hidden" name="username" value='empty' />
                
              <?php
            } else{
                echo "<span class='text-red'>User not found</span>";  
            }
        } else{
            echo "<span class='text-red'>There was a technical error</span>";  
        }
        
    }

    // delete user from the list
    public function DeleteUser($user_id) {
        global $connect;
        $delete = "update users set deleted = 'yes' where id=$user_id";
        if($delete == true){
            $connect->query($delete);
            echo "<span class='text-green'>User deleted</span>";
        } else{
            echo "<span class='text-red'>There was a technical error, couldn't delete user</span>";
        }
        
    }

     // login
     public function Login($username, $password) {
        global $connect;
        $pass = md5($password);
        $select = "
        select *, role from users 
        inner join user_roles on (user_roles.user_id=users.id)
        where username=\"$username\" and password=\"$pass\" and deleted = 'no'";
        if($select == true){
            $execute = $connect->query($select);
            if($execute->num_rows == 1){
                $fetch = $execute->fetch_assoc();
                $username = $fetch['username'];
                $role = $fetch['role'];
                $_SESSION['user'] = $username;
                $_SESSION['role'] = $role;
                ?>
                <script>
                    window.location.href = '../';
                </script>
                <?php
            } else{
                echo "<span class='text-red'>Incorrect login</span>";
            }
        } else{
            echo "<span class='text-red'>There was a technical error, couldn't delete user</span>";
        }
        
    }
}

// execute functions inside Logic class
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST['q'] == 'add_user'){
        $Logic = new Logic();
        $Logic->AddUser($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['cell'], $_POST['username'], $_POST['password'], $_POST['address'], $_POST['job_title'], 0, $_POST['user_roles']);
    }

    elseif($_POST['q'] == 'update_user'){
        $Logic = new Logic();
        $Logic->AddUser($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['cell'], $_POST['username'], $_POST['password'], $_POST['address'], $_POST['job_title'], $_POST['user_id'], $_POST['user_roles']);
    }

    elseif($_POST['q'] == 'login_user'){
        $Logic = new Logic();
        $Logic->Login($_POST['username'], $_POST['password']);
    }

} 

// fire PUT method to update to archive user deleted
elseif($_SERVER['REQUEST_METHOD'] == 'PUT'){
    parse_str(file_get_contents("php://input"), $_PUT);
        $Logic = new Logic();
        $Logic->DeleteUser($_PUT['user_id']);
    
} 


?>
