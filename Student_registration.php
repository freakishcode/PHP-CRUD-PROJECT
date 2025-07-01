<?php

require_once '../PHP_Project/DATABASE_Configuration/Database_for_student.php';

// Define variables and initialize with empty values
$ProfilePicture = $username = $email = $last_name = $first_name = $Faculty_And_Department =  $JAMB_Reg_No = $phoneNumber = $DateOfBirth = $state_of_origin = $LGA = $gender = $password = $confirm_password = "";

// Define variables and initialize with empty values FOR ERROR HANDLING
$username_err = $Email_Error = $ErrorMessage = $Faculty_And_Department_err  = $date_of_birth_err = $state_of_origin_err  = $PhoneNo_Error = $gender_err = $password_err = $confirm_password_err = $msg = "";
if ($_SERVER["REQUEST_METHOD"] ==  "POST") {
    // collecting Data from form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $last_name = trim($_POST['last_name']);
    $first_name = trim($_POST['first_name']);
    $Faculty_And_Department = trim($_POST['faculty_department']);
    $JAMB_Reg_No = trim($_POST['JAMB_Reg_No']);
    $phoneNumber = trim($_POST['phone_number']);
    $DateOfBirth = trim($_POST['date_of_birth']);
    $state_of_origin = trim($_POST['state_of_origin']);
    $LGA = trim($_POST['LGA']);
    $gender = trim($_POST['gender']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);


    if (isset($_FILES['my_imageFile']) && $_FILES['my_imageFile']['error'] === 0) {
        // image extension that will be allowed to be uploaded
        $allowedFiles = [
            'jpg' => 'image/jpg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            "svg" => "image/svg",
        ];

        //image upload
        $ProfilePicture = $_FILES['my_imageFile']['name'];
        $filetype = $_FILES["my_imageFile"]["type"];
        $filesize = $_FILES["my_imageFile"]["size"];
        $temporary_img_loc = $_FILES["my_imageFile"]["tmp_name"];
        $image_location = 'UploadImageOfStudent/' . $ProfilePicture;

        $verifyFile = pathinfo($ProfilePicture, PATHINFO_EXTENSION);

        if (!array_key_exists($verifyFile, $allowedFiles)) {
            $msg = "<p style='color: yellow;'>IMAGE FORMAT REJECTED: Only jpg,jpeg,png & svg allowed</p>";
        }

        // checking if image file is not more than 2mb
        $getSize = 2 * 1024 * 1024;

        if ($filesize > $getSize) {
            $msg = "<p style='color: yellow;'>FILE TOO LARGE, It should be below 2MB</p>";
        }

        if (in_array($filetype, $allowedFiles)) {
            //checking if file is doesn't exist twice in database
            if (!file_exists('UploadImageOfStudent/')) {
                $msg = "<P style='color: yellow;'>$ProfilePicture fail to upload due to incomplete info</P>";
            } else {
                move_uploaded_file($temporary_img_loc, $image_location);
                $msg = "<P style='color: green;'>IMAGE UPLOADED SUCCESSFUL</P>";
            };
        }
    } else {
        $msg = "NO IMAGE UPLOADED";
    }

    //validate username
    if (empty($username)) {
        $username_err = "Username Required";
    } else {
        $username = trim($_POST['username']);
    }

    // Validating Email
    if (empty($email)) {
        $Email_Error = "Email Required";
    } elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $Email_Error = "This is Not an Email";
    } else {
        $email = trim($_POST['email']);
    }

    // Validating Last Name AND First Name
    if (empty($last_name) && empty($first_name)) {
        $ErrorMessage = "Full Name is Required";
    } elseif (!preg_match("/^[a-zA-Z]*$/", $last_name) || !preg_match("/^[a-zA-Z]*$/", $first_name)) {
        $ErrorMessage = "Only Alphabet allowed";
    } else {
        $last_name = trim($_POST['last_name']);
        $first_name = trim($_POST['first_name']);
    }

    // Validating student Faculty_And_Department
    if (empty($Faculty_And_Department)) {
        $Faculty_And_Department_err = "Please Specify Your Faculty And Course of study";
    } else {
        $Faculty_And_Department = trim($_POST['faculty_department']);
    }

    // Validating student JAMB_Reg_No
    if (empty($JAMB_Reg_No)) {
        $ErrorMessage = "Input required";
    } else {
        $JAMB_Reg_No = trim($_POST['JAMB_Reg_No']);
    }

    // // Validating Phone Number
    if (empty($phoneNumber)) {
        $PhoneNo_Error = "Phone Number Required";
    } elseif (strlen(trim($_POST['phone_number'])) < 11) {
        $PhoneNo_Error = "Phone Number must be 11 Digits Only";
    } else {
        $phoneNumber = trim($_POST['phone_number']);
    }

    //validate date_of_birth
    if (empty($DateOfBirth)) {
        $date_of_birth_err = "date_of_birth Required";
    } else {
        $DateOfBirth = trim($_POST['date_of_birth']);
    }

    //validate state_of_origin
    if (empty($state_of_origin)) {
        $state_of_origin_err = "state_of_origin Required";
    } else {
        $state_of_origin = trim($_POST['state_of_origin']);
    }

    //validate L.G.A
    if (empty($LGA)) {
        $ErrorMessage = "Input required";
    } else {
        $LGA = trim($_POST['LGA']);
    }

    //validate Student Gender
    if (empty($gender)) {
        $gender_err = "please state your gender";
    } else {
        $gender = trim($_POST['gender']);
    }

    //validate password
    if (empty($password)) {
        $password_err = "Please enter a password";
    } elseif (strlen($password) < 5) {
        $password_err = "Password must have more than 8 characters";
    } else {
        $password = trim($_POST['password']);
    }

    //confirm password
    if (empty($confirm_password)) {
        $confirm_password_err = "Please confirm password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // insert into database but we must check if we do not have any error
    if (empty($username_err) && empty($Email_Error) && empty($ErrorMessage)  && empty($Faculty_And_Department_err) && empty($PhoneNo_Error) && empty($date_of_birth_err) && empty($state_of_origin_err) && empty($gender_err) && empty($password_err) && empty($confirm_password_err)) {

        $sql = "INSERT INTO students (ProfilePicture, username, email, last_name, first_name, faculty_dept, JAMB_reg_no, phone_no, date_of_birth, state_of_origin, LGA, gender, password) VALUES (?, ?, ?, ?, ? , ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($connectLink, $sql)) {

            mysqli_stmt_bind_param($stmt, "sssssssisssss", $ProfilePicture, $param_username, $email, $last_name, $first_name, $Faculty_And_Department, $JAMB_Reg_No, $phoneNumber, $DateOfBirth, $state_of_origin, $LGA, $gender, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = $password;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // executing the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: ./login_student.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close the statement
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
    <title>Student Registration</title>

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
            min-height: 50rem;
        }

        .form-container {
            padding: .75rem;
            position: absolute;
            top: 55%;
            left: 50%;
            translate: -50% -45%;
            border: none;
            outline: none;
            border-radius: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            box-shadow: 5px 7px 10px black;
        }

        h3 {
            text-shadow: 7px 6px 5px black;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: .75rem;
            padding: 0.75rem;
        }

        .profile-pic-div {
            height: 200px;
            width: 200px;
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid #dddd;
        }

        #photo {
            height: 100%;
            width: 100%;
        }

        #file {
            display: none;
        }

        #uploadBtn {
            height: 40px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            color: #fff;
            background-color: rgb(0, 0, 0, 0.7);
            line-height: 30px;
            font-size: 15px;
            cursor: pointer;
            display: none;
        }

        .Display-grid {
            text-transform: capitalize;
            font-style: capitalize;
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, 1fr);
        }

        .Display-grid input {
            width: 22rem;
            text-transform: capitalize;
        }

        .other-inputField input {
            width: 24rem;
            text-transform: lowercase;
        }

        input {
            border: none;
            outline: none;
            padding: 0.6rem;
            font-weight: bold;
            border-radius: 7px;
            caret-color: RED;
            font-family: "Font Awesome 6 Free";
        }

        input:focus {
            border: 2px solid blue;
        }

        input::placeholder {
            font-size: 17px;
            color: #6f085a;
        }

        .Gender {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
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

        .Error-message {
            text-align: center;
            font-style: italic;
            color: red;
            font-size: 1.2rem;
            font-weight: x-large;
        }

        .Already:hover a {
            color: red;
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
            .form-container {
                top: 70%;
            }

            .Display-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="form-container hidden">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

            <!-- upload Student profile Picture -->
            <div class="profile-pic-div">
                <img src="../PHP_Project/UploadImageOfStudent/Avatar.png" alt="Avatar" id="photo" />
                <input type="file" id="file" name="my_imageFile" />
                <label for="file" id="uploadBtn">Choose Photo</label>
            </div>

            <!-- Error Message to user if the required condition is not fulfilled -->
            <div style="z-index:1;" class="Error-message"><?php echo $msg; ?></div>

            <!-- header -->
            <h3>Student Registration</h3>

            <!-- Student Details -->
            <div class="Display-grid">
                <!-- username -->
                <label>
                    <input type="text" value="<?php if (isset($username)) {
                                                    echo $username;
                                                } ?>" placeholder="&#xf007  Username" name="username" />
                    <div class="Error-message"><?php echo $username_err; ?></div>
                </label>

                <!-- email -->
                <label>
                    <input type="email" value="<?php if (isset($email)) {
                                                    echo $email;
                                                } ?>" placeholder="&#xf0e0  Your Email" name="email" />
                    <div class="Error-message"><?php echo $Email_Error; ?></div>
                </label>

                <!-- last name -->
                <label>
                    <input type="text" value="<?php if (isset($last_name)) {
                                                    echo $last_name;
                                                } ?>" placeholder="&#xf2bd  Last Name" name="last_name" />
                    <div class="Error-message"><?php echo $ErrorMessage; ?></div>
                </label>

                <!-- first name -->
                <label>
                    <input type="text" value="<?php if (isset($first_name)) {
                                                    echo $first_name;
                                                } ?>" placeholder="&#xf2bd First Name" name="first_name" />
                    <div class="Error-message"><?php echo $ErrorMessage; ?></div>
                </label>

                <!--Faculty_And_Department -->
                <label for="Faculty And Department">
                    <input type="text" value="<?php if (isset($Faculty_And_Department)) {
                                                    echo $Faculty_And_Department;
                                                } ?>" name="faculty_department" placeholder="Faculty And Department" />
                    <div class="Error-message"><?php echo $Faculty_And_Department_err; ?></div>
                </label>

                <!-- jamb-reg-no -->
                <label>
                    <input type="text" value="<?php if (isset($JAMB_Reg_No)) {
                                                    echo $JAMB_Reg_No;
                                                } ?>" placeholder="&#xf2bb  JAMB Reg No." name="JAMB_Reg_No" />
                    <div class="Error-message"><?php echo $ErrorMessage; ?></div>
                </label>

                <!-- phone number -->
                <label>
                    <input type="number" value="<?php if (isset($phoneNumber)) {
                                                    echo $phoneNumber;
                                                } ?>" placeholder="&#xf095  Phone Number" name="phone_number" />
                    <div class="Error-message"><?php echo $PhoneNo_Error; ?></div>
                </label>

                <!-- DATE OF BIRTH -->
                <label for="DATE OF BIRTH">
                    <input type="date" value="<?php if (isset($DateOfBirth)) {
                                                    echo $DateOfBirth;
                                                } ?>" name="date_of_birth" placeholder="Date of Birth" />
                    <div class="Error-message"><?php echo $date_of_birth_err; ?></div>
                </label>

                <!-- STATE OF ORIGIN -->
                <label for="STATE OF ORIGIN">
                    <input type="text" value="<?php if (isset($state_of_origin)) {
                                                    echo $state_of_origin;
                                                } ?>" name="state_of_origin" placeholder="State of Origin" />
                    <div class="Error-message"><?php echo $state_of_origin_err; ?></div>
                </label>

                <!-- LOCAL GOVERNMENT AREA -->
                <label for="LGA">
                    <input type="text" value="<?php if (isset($LGA)) {
                                                    echo $LGA;
                                                } ?>" name="LGA" placeholder="Local Government Area" />
                    <div class="Error-message"><?php echo $ErrorMessage; ?></div>
                </label>

                <!-- password -->
                <label>
                    <input type="password" placeholder="&#xf09c  Password" name="password" />
                    <div class="Error-message"><?php echo $password_err; ?></div>
                </label>

                <!-- confirm password -->
                <label>
                    <input type="password" placeholder="&#xf023  confirm  password" name="confirm_password" />
                    <div class="Error-message"><?php echo $confirm_password_err; ?></div>
                </label>
            </div>

            <!-- Gender -->
            <div class="Gender">
                <h4>Gender:</h4>
                <label>
                    Male
                    <input type="radio" checked name="gender" value="Male">
                </label>
                <label>Female
                    <input type="radio" name="gender" value="Female">
                </label>
                <div class="Error-message"><?php echo $gender_err; ?></div>
            </div>

            <!-- button to submit form -->
            <button type="submit">Register</button>

            <!-- link to login if user have an account -->
            <p class="Already">Already have an account? <a href="Login_student.php">Login here</a>.</p>

        </form>
        <!-- copyright -->
        <div style='text-align:center'>&copy; Copyright 2022 By Bolaji Bakare</div>
    </div>

    <script>
        //Declaring HTML elements
        const imgDiv = document.querySelector(".profile-pic-div");
        const img = document.querySelector("#photo");
        const file = document.querySelector("#file");
        const uploadBtn = document.querySelector("#uploadBtn");
        //declaration of Variable database usage
        var upload_image = "";

        //if user hover 'ON' Profile Picture
        imgDiv.addEventListener("mouseenter", function() {
            uploadBtn.style.display = "block";
        });

        //if user hover 'OUT' Profile Picture
        imgDiv.addEventListener("mouseleave", function() {
            uploadBtn.style.display = "none";
        });

        //image showing functionality when user choose an image to upload
        file.addEventListener("change", function() {
            //this refers to file
            const chosenFile = this.files[0];

            if (chosenFile) {
                const reader = new FileReader();
                //FileReader is a predefined function of JavaScript
                reader.addEventListener('load', function() {
                    upload_image = reader.result;
                    img.setAttribute('src', upload_image);
                });
                reader.readAsDataURL(chosenFile);
            }
        });

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