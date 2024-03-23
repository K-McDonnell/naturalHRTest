<?php
session_start();

require '../database/connector.php';

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // Build new user data
    $user = [];
    $user['user_name'] =  $_POST['username'];
    $user['email'] = $_POST['email'];
    $user['password_1'] = $_POST['password_1'];
    $user['password_2'] = $_POST['password_2'];

    // first check the database to make sure
    // a user does not already exist with the same username and/or email

    $sql = $db->prepare('SELECT * FROM users WHERE username=? OR email=? LIMIT 1');
    $sql->execute([$_POST['username'],$_POST['email'] ]);
    $result = $sql->fetchAll();

    $existingUser = $result;
    if(isset($existingUser[0])) {
        $errors = validateRegistration($existingUser);
    }
    var_dump($result);
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($user['password_1']);//encrypt the password before saving in the database
        $sql = $db->prepare( "INSERT INTO users (username, email, password) VALUES(?,?,?)")->execute([$user['user_name'],$user['email'],$password]);

        $_SESSION['username'] = $user['user_name'];
        $_SESSION['success'] = true;
        header('Location: http://localhost');
    }
}


// LOGIN USER
if (isset($_POST['login_user'])) {
    $user_name = $_POST['username'];
    $password =  $_POST['password'];

    if (empty($user_name)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);

        $sql = $db->prepare('SELECT * FROM users WHERE username=? AND password=?');
        $sql->execute([$user_name,$password]);
        $result = $sql->fetchAll();

        if (count($result) == 1) {
            $_SESSION['username'] = $user_name;
            $_SESSION['success'] = true;
            $_SESSION['user_profile_img'] = $result['file_location'] ?? null;
            header('Location: http://localhost');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}


function validateRegistration(&$existingUser, $newUser){
    $errors = [];
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($newUser['user_name'])) { array_push($errors, "Username is required"); }
    if (empty($newUser['email'])) { array_push($errors, "Email is required"); }
    if (empty($newUser['password_1'])) { array_push($errors, "Password is required"); }
    if ($newUser['password_1'] != $newUser['password_2']) {
        array_push($errors, "The two passwords do not match");
    }

    if (isset($existingUser['username'])) { // if user exists
        if ($newUser['username'] === $existingUser['user_name']) {
            array_push($errors, "Username already exists");
        }

        if ($newUser['email'] === $existingUser['email']) {
            array_push($errors, "email already exists");
        }
    }
}

?>