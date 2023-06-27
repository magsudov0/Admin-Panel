<?php
include "functions/connections.php";
include "functions/functions.php";

if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    session_start();
    $_SESSION['user_login'] = 'yes';
    header('Location: index.php');
    exit;
} else {

    $username = $password = $usernameError = $passwordError = $loginError = $captchaError = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $secretKey = '6LdyJuwlAAAAANTVJOgrBsXoFKg13hBFVXN_PoNF';

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secretKey,
            'response' => $recaptchaResponse
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
        if (!$response['success']) {
            $captchaError = "You're Robot";
        }

        if ($_POST['username'] == '') {
            $usernameError = "Username is required";
        } else {
            $username = clearInput($_POST["username"]);
            if (!preg_match("/^[a-z A-Z' ]*$/", $username)) {
                $usernameError = "Only letters allowed";
            }
        }

        if ($_POST['password'] == '') {
            $passwordError = "Password is required";
        } else {
            $password = md5($_POST["password"]);
        }

        if ($usernameError == "" and $passwordError == "" and $captchaError == "") {

            $sql_login = "SELECT * FROM users WHERE `username` = '$username' and `password` = '$password'";

            $result = mysqli_query($conn, $sql_login);

            if (mysqli_num_rows($result) > 0) {

                session_start();
                $_SESSION['user_login'] = 'yes';
                if (isset($_POST['remember_me'])) {
                    setcookie("username", $_POST['username'], time() + (86400 * 30), "/"); // Cookie expires in 30 days
                }
                header('Location: index.php');
            } else {
                $loginError = "Username or password is wrong";
            }
        }
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="assets/main.js"></script>
    <script src="https://kit.fontawesome.com/da3bb39bb1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <header class="header">
            <img id="logo" src="assets/image/121.png" alt="logo">
            <span id="title">İslahat Könüllülərinin İdarəetmə sistemi</span>
        </header>
        <main class="main">
            <div class="inputArea">
                <form id="form" action="" method="post">
                    
                    <!-- <div class="alert alert-danger" role="alert">
                        error
                    </div> -->

                    <p id="userName">Username</p>
                    <input class="userArea" name="username" type="text" value="<?php echo $username; ?>"><br>
                    <img class="fa-user" src="assets/image/user-icon.png">
                    
                    <p id="passWord">Password</p>
                    <input class="passArea" id="password" name="password" type="password">
                    <img id="passLogo" src="assets/image/Vector.png">
                    <img id="eyeIconHide" class="hide" onclick="hiden()" src="assets/image/hide.png">
                    <img id="eyeIconView" class="view" onclick="viewer()" src="assets/image/view.png">
                    
                    <div class="rememberMe">
                        <input type="checkbox" name="remember_me" value="lsRememberMe" id="rememberMe"> <label
                            for="rememberMe">Remember
                            me</label><br><br>
                        <div class="g-recaptcha" data-sitekey="6LdyJuwlAAAAAGQ8KFKSowS2Pjel2w0FCxuvd41x">
                        </div>

                        <input class="loginButton" type="submit" value="Login" onclick="lsRememberMe()">

                    </div>

                    

                </form>
            </div>
        </main>
    </div>
</body>

</html>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>