<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户<?= $tip ?></title>
</head>
<body>
    <h1>用户<?= $tip ?></h1>
    <br>
    <form action="<?= $action ?>" method="post">
        <label for="">用户名：</label><input type="text" name="user_name">
        <br>
        <label for="">密&nbsp;&nbsp;&nbsp;&nbsp;码：</label><input type="password" name="user_pass">
        <br><br>
        <input type="submit"><label for="" style="color:red"><?= $error_msg ?></label>
    </form>
</body>
</html>
