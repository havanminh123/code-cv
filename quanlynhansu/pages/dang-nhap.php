
<?php

session_start();
error_reporting(0);

include('../config.php');

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    header("Location: index.php");
} else {

    if (isset($_POST['login'])) {
        // array error
        $error = array();
        // array success
        $success = array();
        // showMess
        $showMess = false;

        // validate form 
        if (empty($_POST['email'])) {
            $error['email'] = 'You have not entered <b> email </b>';
        }

        if (empty($_POST['password'])) {
            $error['password'] = 'You have not entered <b> Password </b>';
        }

        if (!$error) {

            $email = $_POST['email'];
            $password = md5($_POST['password']);

            // check user
            $check = "SELECT email, mat_khau, quyen, truy_cap FROM tai_khoan WHERE email = '$email'";
            $result = mysqli_query($conn, $check);
            $row = mysqli_fetch_array($result);
            $level = $row['quyen'];

            if (mysqli_num_rows($result) == 1) {
                if ($row['mat_khau'] == $password) {
                    $showMess = true;
                    // create var session username
                    $_SESSION['username'] = $email;
                    // create var session level
                    $_SESSION['level'] = $level;

                    // set access
                    $access = $row['truy_cap'] + 1;
                    $update = "UPDATE tai_khoan SET truy_cap = $access WHERE email = '$email'";
                    mysqli_query($conn, $update);

                    $success['mess'] = 'Log in Success';
                    header("Refresh: 1; index.php?p=index&a=statistic");
                } else {
                    $error['check'] = '<b>Incorrect Password</b>. Please try again';
                }
            } else {
                $error['check'] = 'Invalid input <b> Email </b>. Please try again';
            }
        }
    }

?>

    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Đăng Input - HRM</title>
        <link rel="shortcut icon" href="../dist/images/logo.jpg" type="image/x-icon" />
        <style>
            /* Reset CSS */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #ff9a9e, #fad0c4, #fbc2eb);
                background-size: 300% 300%;
                animation: gradient-animation 5s infinite;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            @keyframes gradient-animation {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            .login-container {
                background: rgba(255, 255, 255, 0.9);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                width: 100%;
                max-width: 400px;
                text-align: center;
                backdrop-filter: blur(10px);
            }

            .login-form h2 {
                margin-bottom: 20px;
                color: #333333;
                font-size: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }

            .login-form h2 i {
                color: #6e8efb;
            }

            .input-group {
                margin-bottom: 20px;
                text-align: left;
                position: relative;
            }

            .input-group label {
                display: block;
                margin-bottom: 5px;
                color: #555555;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .input-group input {
                width: 100%;
                padding: 12px 10px 12px 35px;
                border: 2px solid #dddddd;
                border-radius: 8px;
                font-size: 16px;
                transition: all 0.3s ease;
                background: transparent;
            }

            .input-group input:focus {
                border-color: #6e8efb;
                box-shadow: 0 0 8px rgba(110, 142, 251, 0.5);
            }

            .input-group i {
                position: absolute;
                left: 10px;
                top: 67%;
                transform: translateY(-50%);
                color: #aaaaaa;
            }

            .login-button {
                width: 100%;
                padding: 12px;
                background: #6e8efb;
                color: white;
                border: none;
                border-radius: 8px;
                font-size: 16px;
                cursor: pointer;
                transition: background 0.3s ease, transform 0.3s ease;
            }

            .login-button:hover {
                background: #5a7de2;
                transform: scale(1.05);
            }

            .forgot-password {
                margin-top: 15px;
                font-size: 14px;
            }

            .forgot-password a {
                color: #6e8efb;
                text-decoration: none;
                transition: color 0.3s ease;
                display: flex;
                align-items: center;
                gap: 5px;
            }

            .forgot-password a:hover {
                color: #5a7de2;
            }
        </style>
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>
        <?php
        if (isset($error)) {
            if ($showMess == false) {
                // echo "<div class='alert alert-danger alert-dismissible notify'";
                // echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true' ></button>";
                foreach ($error as $err) {
                    echo "<script>alert('". $err ."')</script>";
                }
                // echo "</div>";
            }
        }
        ?>

        <div class="login-container">
            <form class="login-form box" method="POST" name="form1" onsubmit="return checkStuff()" autocomplete="off">
                <h2><i class="fas fa-user-circle"></i> Log in</h2>
                <div class="input-group">
                    <span class="error animated tada" id="msg"></span>
                </div>
                <div class="input-group">
                    <label for="username"><i class="fas fa-user"></i> Name Log in</label>
                    <input type="text" id="username" placeholder="Input name Log in" required name="email" autocomplete="off"
                    value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password"  id="pwd" autocomplete="off" placeholder="Input Password" required>
                </div>
                <!-- <button type="submit" class="login-button">Log in</button> -->
                <input type="submit" value="Log in" name="login" class="login-button">
                <p class="forgot-password"><a href="#"><i class="fas fa-question-circle"></i> 
                Forgot Password?</a></p>
            </form>
        </div>


        <script>
            function checkStuff() {
                var email = document.form1.email;
                var password = document.form1.password;
                var msg = document.getElementById('msg');

                console.log(email, password, msg)
                return

                if (email.value == "") {
                    msg.style.display = 'block';
                    msg.innerHTML = "Please enter your email";
                    email.focus();
                    return false;
                } else {
                    msg.innerHTML = "";
                }

                if (password.value == "") {
                    msg.innerHTML = "Please enter your password";
                    password.focus();
                    return false;
                } else {
                    msg.innerHTML = "";
                }
                var re =
                    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!re.test(email.value)) {
                    msg.innerHTML = "Please enter a valid email";
                    email.focus();
                    return false;
                } else {
                    msg.innerHTML = "";
                }
            }
        </script>
    </body>

    </html>


<?php
}
// end check session
?>