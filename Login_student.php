<?php
// Initialize the session
session_start();

//Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: Course_Registration.html");
    exit;
}

// Include config file
require_once "./DATABASE_Configuration/Database_for_student.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Checking if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your Username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Checking if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } elseif (strlen($_POST["password"]) < 6) {
        $password_err = "Password must NOT be lesser than 6";
    } else {
        $password = trim($_POST["password"]);
    }


    // Validate credentials
    if (empty($username_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, username, password FROM students WHERE username = ?";

        if ($stmt = mysqli_prepare($connectLink, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome dashboard page
                            header("location: ./Course_Registration.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $password_error = "Invalid Password";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $username_error = "Username doesn't exist";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($connectLink);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Registered Student</title>

    <!-- Font-Awesome offline link -->
    <link rel="stylesheet" href="../fontawesome-free-6.1.2-web/css/all.css" />

    <style>
        /* Universal selector or Global styling */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            list-style: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            background-color: #2c3e50;
            color: #fff;
        }

        .form-container {
            padding: .7rem;
            position: absolute;
            top: 50%;
            left: 50%;
            translate: -50% -50%;
            border: none;
            outline: none;
            border-radius: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            box-shadow: 5px 7px 10px black;
        }

        h2 {
            background: linear-gradient(45deg, #ff0, #f0f);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: .75rem;
            margin-top: 0.75rem;
            padding: 0.75rem;
        }

        input[type="text"],
        input[type="password"] {
            width: 20em;
            border: none;
            outline: none;
            padding: 0.75rem;
            font-size: 1rem;
            border-radius: 7px;
            caret-color: RED;
            font-family: "Font Awesome 6 Free";
        }

        input:focus {
            border: 2px solid blue;
        }

        input::placeholder {
            font-size: large;
            font-weight: bold;
            color: #6f085a;
        }

        button {
            width: 199px;
            border: none;
            outline: none;
            padding: 0.5rem;
            border-radius: 7px;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 5px 7px 5px rgb(0, 0, 0.5);
            color: #fff;
            background-color: rgb(18, 18, 230);
        }

        button:hover {
            color: #101010;
            background-color: #48b1df;
        }

        button:active {
            scale: 0.92;
            color: #fff;
            background-color: red;
        }

        .Already:hover a {
            color: red;
        }

        .Error-message {
            padding: .2rem;
            text-align: center;
            font-style: italic;
            color: red;
            font-size: 1.2rem;
            font-weight: x-large;
        }

        /* ANIMATE PAGE FOR JS USE ONLY*/
        .hidden {
            opacity: 0;
            filter: blur(5px);
            transition: all 1s;
        }

        .show {
            opacity: 1;
            filter: blur(0);
        }

        @media (max-width: 66rem) {

            /* prevent animation on mobile phones */
            .hidden {
                transition: none;
            }
        }
    </style>
</head>

<body>
    <div class="form-container hidden">
        <form action="" method="POST">
            <!-- header -->
            <h2>Login Student</h2>
            <!-- user Avatar -->
            <img src="./UploadImageOfStudent/User_Avatar.png" alt="User_Avatar">

            <!-- USERNAME-->
            <div>
                <?php
                if (!empty($username_error)) {
                    echo '<div class="Error-message">' . $username_error . '</div>';
                }
                ?>
                <input type="text" value="<?php if(isset($username)){echo $username;}?>" placeholder="&#xf007  Username" name="username" />
                <div class="Error-message"><?php echo $username_err; ?></div>
            </div>

            <!-- Password-->
            <div>
                <input type="password" placeholder="&#xf023  Password" name="password" />
                <div class="Error-message"><?php echo $password_err; ?></div>
                <?php
                if (!empty($password_error)) {
                    echo '<div class="Error-message">' . $password_error . '</div>';
                }
                ?>
            </div>

            <!-- remember me checkbox-->
            <div>
                <input type="checkbox" name="remember_me" id="remember-me">
                <label for="remember-me">Remember me</label>
            </div>

            <button type="submit">Login</button>
            <p class="Already">Don't have an account? <a href="Student_registration.php">Sign up now</a>.</p>
        </form>
    </div>

    <script>
        //use js to apply animation when user opens page
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                } else {
                    entry.target.classList.remove("show");
                }
            });
        });

        const hiddenElements = document.querySelectorAll(".hidden");
        hiddenElements.forEach((el) => observer.observe(el));
    </script>
</body>

</html>