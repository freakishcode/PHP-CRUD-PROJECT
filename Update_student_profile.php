<?php
//adding database configuration file
include '../PHP_Project/DATABASE_Configuration/Database_for_student.php';

// Define variables and initialize with empty values
$id = $ProfilePicture = $username = $email = $last_name = $first_name = $Faculty_And_Department =  $JAMB_Reg_No = $phoneNumber = $DateOfBirth = $state_of_origin = $LGA = $gender = "";
$ErrorMessage = $PhoneNo_Error = $msg = "";

$get_data = "SELECT * FROM students LIMIT 1";
// using LIMIT 1 to limit the the no of row to select to 1 only & not all student that registered
$run_data = mysqli_query($connectLink, $get_data);
while ($row = mysqli_fetch_array($run_data)) {
    //need id to update student from
    $user_id = $row['id'];

    //getting the rest to display into input
    $user_ProfilePicture = $row['ProfilePicture'];
    $user_email = $row['email'];
    $user_last_name = $row['last_name'];
    $user_first_name = $row['first_name'];
    $user_faculty_dept = $row['faculty_dept'];
    $user_JAMB_reg_no = $row['JAMB_reg_no'];
    $user_phone_no = $row['phone_no'];
    $user_date_of_birth = $row['date_of_birth'];
    $user_state_of_origin = $row['state_of_origin'];
    $user_LGA = $row['LGA'];
    $user_gender = $row['gender'];
}

if ($_SERVER["REQUEST_METHOD"] ==  "POST") {
    // collecting Data from form
    $id = $_POST['id'];
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

    // for image update and validating also
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

    //updating part
    $sql = "UPDATE students SET ProfilePicture = ? , email = ?, last_name = ?, first_name = ?, faculty_dept = ?, JAMB_reg_no = ?, phone_no = ?, date_of_birth = ?, state_of_origin = ?, LGA = ?, gender = ? WHERE id = ? ";
    // using prepared statement(NOTE:procedure method)
    if ($stmt = mysqli_prepare($connectLink, $sql)) {
        // binding the database to user input to fill up the ? part
        mysqli_stmt_bind_param($stmt, "ssssssissssi", $ProfilePicture, $email, $last_name, $first_name, $Faculty_And_Department, $JAMB_Reg_No, $phoneNumber, $DateOfBirth, $state_of_origin, $LGA, $gender, $id);

        // executing the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to Course Registration page
            header("location: ./Course_Registration.php");
        } else {
            echo "Execution Failed";
        }
        // Close the statement
        mysqli_stmt_close($stmt);
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
    <title>Document</title>
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
            color: #000;
            margin: 20px;
            min-height: 50rem;
        }

        form {
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: .75rem 0;
            border: 1px solid red;
            padding: 1rem;
        }

        h1 {
            background: linear-gradient(45deg, #6f085a, #f0f, #f00);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .profile-pic-div {
            height: 250px;
            width: 250px;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid red;
            position: relative;
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

        .INPUT-DATA {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            place-items: center;
            gap: 1rem;
        }

        input::placeholder {
            color: #6f085a;
            text-align: center;
        }

        input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 20px;
            padding: 0.3em;
            /* text-transform: capitalize; */
            border-bottom: 1px solid orangered;
            background-color: inherit;
            color: #000;
            text-align: center;
        }

        label {
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            color: #6f085a;
        }

        .Gender {
            border: none;
            outline: none;
            width: 100%;
            font-size: 20px;
            padding: 0.3em;
            border-bottom: 1px solid orangered;
            background-color: inherit;
            color: #6f085a;
        }

        .logout {
            position: absolute;
            top: 0;
            right: 0;
            width: 85px;
            margin: 1rem;
            padding: 0.5rem;
            border-radius: 7px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 5px 7px 5px rgb(0, 0, 0.5);
            background-color: #000;
            z-index: 2;
        }

        input[type="submit"] {
            width: 40%;
            margin: .75rem;
            font-size: 17px;
            font-weight: bold;
            border: none;
            outline: none;
            padding: 0.5em;
            border-radius: 10px;
            cursor: pointer;
            background-color: #6f085a;
            color: #fff;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.4);
        }

        input[type="submit"]:active,
        .logout:active {
            color: #fff;
            background-color: red;
        }

        input[type="submit"]:hover,
        .logout:hover {
            scale: 0.92;
            color: #fff;
            background-color: blue;
        }

        .Error-message {
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
            transform: translateY(-100%);
            transition: all 1s;
        }

        .show {
            opacity: 1;
            filter: blur(0);
            transform: translateX(0);
        }

        @media (max-width: 66rem) {
            .INPUT-DATA {
                grid-template-columns: 1fr;
            }

            /* prevent animation on mobile phones */
            .hidden {
                transition: none;
            }
        }
    </style>
</head>

<body>
    <!-- button to logout -->
    <a class="logout" href="./logout_student.php">Log Out</a>

    <form class="hidden" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <!-- header -->
        <h1>UPDATE STUDENT INFO</h1>
        <!-- upload Student profile Picture -->

        <!-- using hidden INPUT to get user Id from SELECT  -->
        <input type="hidden" name="id" value="<?php echo $user_id ?>">
        <!-- echoing out user full name -->
        <h3 style="text-transform: capitalize;">WELCOME <?php echo $user_last_name, ' ', $user_first_name ?></h3>

        <div class="profile-pic-div">
            <!-- Student profile Picture -->
            <img src='<?php echo "../PHP_Project/UploadImageOfStudent/" . $user_ProfilePicture . " " ?>' alt="Avatar" id="photo" />
            <input type="file" id="file" name="my_imageFile" />
            <label for="file" id="uploadBtn">Choose Photo</label>
        </div>
        <!-- Error Message FOR PROFILE PICTURE -->
        <div class="Error-message"><?php echo $msg; ?></div>

        <div class="INPUT-DATA">
            <!-- EMAIL -->
            <label for="EMAIL">CHANGE EMAIL
                <input type="email" name="email" placeholder="CHANGE EMAIL" value="<?php echo $user_email ?>" />
            </label>

            <!-- last name -->
            <label for=" LAST NAME">CHANGE LAST NAME
                <input type="text" name="last_name" placeholder="LAST NAME" value="<?php echo $user_last_name ?>" />
            </label>

            <!-- first name -->
            <label for="FIRST NAME">CHANGE FIRST NAME
                <input type="text" name="first_name" placeholder="FIRST NAME" value="<?php echo $user_first_name ?>" />
            </label>

            <!--Faculty_And_Department -->
            <label for="Faculty And Department">CHANGE Faculty And Department
                <input type="text" name="faculty_department" placeholder="Faculty And Department" value="<?php echo $user_faculty_dept ?>" />
            </label>

            <!-- OTHER NAME -->
            <!-- <label for="OTHER NAME">
                <input type="text" name="other_name" placeholder="OTHER NAME" />
            </label> -->

            <!-- JAMB_reg_no -->
            <label for="JAMB-Reg-No">CHANGE JAMB_reg_no
                <input type="text" name="JAMB_Reg_No" placeholder="CHANGE JAMB_reg_no" value="<?php echo $user_JAMB_reg_no ?>" />
            </label>

            <!-- PHONE NUMBER -->
            <label for="PHONE NUMBER">CHANGE PHONE NUMBER
                <input type="number" name="phone_number" placeholder="PHONE NUMBER" value="<?php echo $user_phone_no ?>" />
            </label>

            <!-- DATE OF BIRTH -->
            <label for="DATE OF BIRTH">DATE OF BIRTH:
                <input type="date" name="date_of_birth" placeholder="Date of Birth" value="<?php echo $user_date_of_birth ?>" />
            </label>

            <!-- STATE OF ORIGIN -->
            <label for="STATE OF ORIGIN">CHANGE STATE OF ORIGIN
                <input type="text" name="state_of_origin" placeholder="STATE OF ORIGIN" value="<?php echo $user_state_of_origin ?>" />
            </label>

            <!-- LOCAL GOVERNMENT AREA -->
            <label for="LGA">CHANGE LOCAL GOVERNMENT AREA
                <input type="text" name="LGA" placeholder="LGA" value="<?php echo $user_LGA ?>" />
            </label>

            <!-- Gender -->
            <label for="Gender">CHANGE Gender
                <select name="gender" class="Gender">
                    <option><?php echo $user_gender ?></option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </label>

        </div>

        <!-- button to submit form -->
        <input type="submit" name="submit Update">

    </form>


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