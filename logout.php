<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
</head>
<body>
<?php include ('inc/navigation.php') ?>
<?php include ('inc/inc.php');?>
<?php session_destroy();
header('Location: login.php');?>

<?php include ('inc/footer.php')?>
</body>
</html> 
