<?php
session_start();

require 'vendor/autoload.php';
require 'database/connector.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: users/login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: users/login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="resources/css/style.css">
</head>
<body>

<div class="header">
    <h2>User Details</h2>
</div>
<div class="content">

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
        <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
        <form class="form-upload" method="POST" enctype="multipart/form-data">
            <input type="file" name="foo" value=""/>
            <input type="submit" value="Upload File"/>
        </form>

        <?php  if (isset($_SESSION['user_profile_img'])) : ?>
            <img class="img-med" src="storage/users/profile/<?php echo $_SESSION['user_profile_img']; ?>">
        <?php endif ?>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>

</body>
</html>

<?php
    $storage = new \Upload\Storage\FileSystem( $_SERVER['DOCUMENT_ROOT'].'/storage/users/profile');
    if(isset($_FILES['foo'])){
        $file = new \Upload\File('foo', $storage);

        // Validate file upload
        $file->addValidations(array(
            new \Upload\Validation\Mimetype(array('image/png', 'image/gif', 'image/jpg', 'image/jpeg')),
            new \Upload\Validation\Size('5M')
        ));

        // Try to upload file
        try {
            $file->upload();
        } catch (\Exception $e) {
            $errors = $file->getErrors();
        }

        // Set session user img
        $_SESSION['user_profile_img'] = $file->getNameWithExtension();
        // Add the file details to the db
        $sql = $db->prepare('SELECT * FROM users WHERE username=? OR email=? LIMIT 1');
        $sql->execute([$_SESSION['username'],$_SESSION['username'] ]);
        $user = $sql->fetchAll();

        if ($user[0]['id']) { // if user exists
            $sql = $db->prepare('UPDATE users set file_location =? WHERE id=?');
            $sql->execute([$file->getNameWithExtension(), $user[0]['id']]);
        }
        echo "<meta http-equiv='refresh' content='0'>";
    }
