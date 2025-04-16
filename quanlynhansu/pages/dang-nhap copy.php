<?php 

session_start();
error_reporting(0);

include('../config.php');

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
	header("Location: index.php");
}
else
{

	if(isset($_POST['login']))
	{
		// array error
		$error = array();
		// array success
		$success = array();
		// showMess
		$showMess = false;

		// validate form 
		if(empty($_POST['email']))
		{
			$error['email'] = 'Bạn chưa input <b> email </b>';
		}

		if(empty($_POST['password']))
		{
			$error['password'] = 'Bạn chưa input <b> Password </b>';
		}

		if(!$error)
		{	
			
			$email = $_POST['email'];
			$password = md5($_POST['password']);

			// check user
			$check = "SELECT email, mat_khau, quyen, truy_cap FROM tai_khoan WHERE email = '$email'";
			$result = mysqli_query($conn, $check);
			$row = mysqli_fetch_array($result);
			$level = $row['quyen'];

			if(mysqli_num_rows($result) == 1)
			{
				if($row['mat_khau'] == $password)
				{
					$showMess = true;
					// create var session username
					$_SESSION['username'] = $email;
					// create var session level
					$_SESSION['level'] = $level;

          // set access
          $access = $row['truy_cap'] + 1;
          $update = "UPDATE tai_khoan SET truy_cap = $access WHERE email = '$email'";
          mysqli_query($conn, $update); 

					$success['mess'] = 'Đăng input Success';
					header("Refresh: 1; index.php?p=index&a=statistic");
				}
				else
				{
					$error['check'] = 'Input sai <b> Password </b>. Please thử lại';
				}
			}
			else
			{
				$error['check'] = 'Input sai <b> Email </b>. Please thử lại';
			}
		}
	}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../dist/images/logo.jpg" type="image/x-icon" />
    <title>ĐĂNG INPUT | MANAGE NHÂN SỰ</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="../dist/css/dang-nhap.css">
    <!-- Google Font -->
	<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition" id="particles-js">
    <div class="login-box-error">
        <?php
			if(isset($error))
			{
				if($showMess == false)
				{
					echo "<div class='alert alert-danger alert-dismissible notify'";
					echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true' ></button>";
					foreach ($error as $err)
					{
						echo $err . "<br/>";
					}
					echo "</div>";
				}
			}
		?>

        <?php 
    	// show success
    	if(isset($success))
    	{
    		if($showMess == true)
    		{
    			echo "<div class='alert alert-success alert-dismissible'>";
	    		echo "<h4><i class='icon fa fa-check'></i> Chúc mừng!</h4>";
	    		foreach ($success as $suc)
	    		{
	    			echo $suc . "<br/>";
	    		}
	    		echo "</div>";
    		}
    	}
    ?>

        <div class="animated bounceInDown">
            <div>
			<div class="container">
                <span class="error animated tada" id="msg"></span>
                <form method="POST" name="form1" class="box" onsubmit="return checkStuff()">
                    <h4>Admin<span>Dashboard</span></h4>
                    <h5>Sign in to your account.</h5>
                    <input type="text" name="email" placeholder="Email" style="font-size:16px" autocomplete="off"
                        value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    <i class="typcn typcn-eye" id="eye"></i>
                    <input type="password" name="password" placeholder="Passsword"  style="font-size:16px" id="pwd" autocomplete="off">
                    <a href="#" class="forgetpass">Forget Password?</a>
                    <input type="submit" value="Sign in" name="login" class="btn1">
                </form>
                <a href="#" class="dnthave">Don’t have an account? Sign up</a>
            </div>
            <div class="footer">
                <span>Made with <i class="fa fa-heart pulse"></i> <a href="#">By Team Lúc Lắc</a></span>
            </div>
			</div>
        </div>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
    });


    // 
    var pwd = document.getElementById('pwd');
    var eye = document.getElementById('eye');

    eye.addEventListener('click', togglePass);

    function togglePass() {

        eye.classList.toggle('active');

        (pwd.type == 'password') ? pwd.type = 'text': pwd.type = 'password';
    }

    // Form Validation

    function checkStuff() {
        var email = document.form1.email;
        var password = document.form1.password;
        var msg = document.getElementById('msg');

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

    // ParticlesJS

    // ParticlesJS Config.
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 60,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 0.1,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 1,
                    "opacity_min": 0.1,
                    "sync": false
                }
            },
            "size": {
                "value": 6,
                "random": false,
                "anim": {
                    "enable": false,
                    "speed": 40,
                    "size_min": 0.1,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.1,
                "width": 2
            },
            "move": {
                "enable": true,
                "speed": 1.5,
                "direction": "top",
                "random": false,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 1200
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": false,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": false,
                    "mode": "push"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 400,
                    "size": 40,
                    "duration": 2,
                    "opacity": 8,
                    "speed": 3
                },
                "repulse": {
                    "distance": 200,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
    </script>
</body>

</html>

<?php 
}
// end check session
?>