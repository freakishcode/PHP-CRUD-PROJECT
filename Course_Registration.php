<?php
// Include config for database & SELECT
include "./select.php";
?>


<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Registration</title>

    <!-- Font-Awesome offline link -->
    <link rel="stylesheet" href="../fontawesome-free-6.1.2-web/css/all.css" />

    <style>
        /* Universal selector or Global styling */
        * {
            margin: 0;
            padding: 0;
            list-style: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        .form-container {
            background: linear-gradient(-45deg, #ff0, #fff, #f0f);
            border: none;
            outline: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: .75rem;
        }

        .form-container h1 {
            padding: 0.75rem;
            text-shadow: 6px 4px rgba(0, 0, 0, 0.3);
        }

        .form-container b {
            color: #6f085a;
        }

        .form-container p {
            font-size: 1.5rem;
        }

        .student-details {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .details {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(2, 1fr);
        }

        #Avatar {
            border: 1px solid #ddd;
            border-radius: 50%;
            height: 200px;
            width: 200px;
        }

        .update-profile>a {
            background: linear-gradient(45deg, #6f085a, #c51c53);
        }

        .update-profile>a:hover {
            background: linear-gradient(45deg, #ff0, #f0f);
            ;

        }

        .Error-Message {
            font-style: italic;
            margin-top: 0.5rem;
            color: red;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
            padding: 0.75rem;
        }

        caption {
            font-size: large;
            font-weight: bolder;
        }

        table {
            width: 600px;
            cursor: pointer;
        }

        table,
        th,
        td {
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
            padding: .75rem;
        }

        th {
            background-color: blue;
        }

        td {
            font-size: 18px;
        }


        tr:nth-child(even):hover {
            background: linear-gradient(45deg, #3fff7c, #3ffbe0);
            color: #101010;
            scale: 1.1;
            transition: 300ms ease-in-out;
        }

        tr:nth-child(odd):hover {
            background: linear-gradient(45deg, #6b2cf5, #3ffbe0);
            color: #fff;
            scale: 1.1;
            transition: 300ms ease-in-out;
        }

        .checkbox input {
            margin: .75rem;
            position: relative;
        }

        .checkbox input::before {
            position: absolute;
            content: "";
            width: 35px;
            height: 35px;
            background-color: #fff;
            border: 2px solid #27ae60;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            translate: -50% -50%;
            cursor: pointer;
            transition: 0.3s all ease;
        }

        .checkbox input:checked::before {
            background-color: darkcyan;
            border: 1px solid darkcyan;
        }

        .checkbox input:checked::after {
            position: absolute;
            /* content: "\2714"; */
            content: "\f00c";
            font-family: "FontAwesome";
            color: #fff;
        }

        button {
            width: 199px;
            border: none;
            outline: none;
            padding: 0.5rem;
            border-radius: 7px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 5px 7px 5px rgb(0, 0, 0.5);
            background-color: rgb(18, 18, 230);
            /* transition: 300ms ease-in-out; */
        }

        button:hover {
            background-color: #48b1df;
            color: #000;
        }

        button:active {
            scale: 0.92;
            color: #fff;
            background-color: red;
        }

        .logout {
            position: absolute;
            right: 0;
            width: 85px;
            margin: 1rem;
            padding: 0.5rem;
            border-radius: 7px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 5px 7px 5px rgb(0, 0, 0.5);
            background-color: rgb(18, 18, 230);
        }

        .btn {
            text-align: center;
            width: 150px;
            padding: 0.5rem;
            border-radius: 7px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 5px 7px 5px rgb(0, 0, 0.5);
            background-color: rgb(18, 18, 230);
        }

        .btn:hover,
        .logout:hover {
            background-color: #48b1df;
            color: #000;
        }

        .btn:active,
        .logout:active {
            scale: 0.92;
            color: #fff;
            background-color: red;
        }

        /* ANIMATE PAGE FOR JS USE ONLY*/
        .hidden {
            opacity: 0;
            filter: blur(5px);
            transform: translateX(-100%);
            transition: all 1s;
        }

        .show {
            opacity: 1;
            filter: blur(0);
            transform: translateX(0);
        }

        @media (max-width: 66rem) {
            .details {
                display: grid;
                gap: 1rem;
                grid-template-columns: 1fr;
                place-items: center;
            }

            table {
                width: 400px;
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

    <div class="form-container">
        <!-- <small><b>WELCOME</b></small> -->

        <!-- header -->
        <h1>COURSE REGISTRATION</h1>

        <div class="student-details hidden">
            <!-- DISPLAYING STUDENT IMAGE -->
            <img src='UploadImageOfStudent/<?= $user_ProfilePicture ?>' alt='Avatar' id='Avatar'>;
            <!-- STUDENT DETAILS -->
            <div class='details'>
                <p><b> Matriculation No: </b><?= $user_JAMB_reg_no ?></p>
                <p><b> Level:</b>Year 4</p>
                <p><b> Last Name: </b><?= $user_last_name ?></p>
                <p><b> First Name: </b><?= $user_first_name ?></p>
                <p><b> Gender: </b><?= $user_gender ?></p>
                <p><b> Faculty/Dept: </b><?= $user_faculty_dept ?></p>
            </div>
        </div>

        <div class="update-profile hidden">
            <!-- button to make changes result -->
            <a class="btn" href="./Update_student_profile.php">UPDATE YOUR PROFILE</a>
        </div>

        <!-- Alert -->
        <?php
        if (isset($_SESSION['status'])) {
            echo "<h4 class= 'Error-Message'>" . $_SESSION['status'] . "</h4>";
            unset($_SESSION['status']);
        }
        ?>

        <!--Course Registration checkbox -->
        <form action="./processCourse.php" method="POST">
            <!-- Alert -->
            <!-- <label for="error_msg"><span id="error_msg"><?php echo $error; ?></span></label> -->

            <!-- list of Course-->
            <table class="hidden">
                <!-- table Title -->
                <caption>
                    PLEASE SELECT YOUR PREFERRED COURSE
                </caption>

                <!--Table heading -->
                <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Course Code</th>
                        <th>Course Tittle</th>
                        <th>Credit Unit</th>
                        <th>Select</th>
                    </tr>
                </thead>

                <!--Table body -->
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>GES 400.1</td>
                        <td>Essential of Entrepreneurship</td>
                        <td>3</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[1]" value="GES 400.1: Essential of Entrepreneurship 3" />
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>MATH 410.1</td>
                        <td>Group Theory</td>
                        <td>2</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[2]" value="MATH 410.1: Group Theory 2" />
                        </td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>MATH 420.1</td>
                        <td>Functional Analysis</td>
                        <td>3</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[3]" value="MATH 420.1: Functional Analysis 3" />
                        </td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>CSC 481.1</td>
                        <td>Data Management</td>
                        <td>3</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[4]" value="CSC 481.1: Data Management 3" />
                        </td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>CSC 498.1</td>
                        <td>Computer Network</td>
                        <td>2</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[5]" value="CSC 498.1: Computer Network 2" />
                        </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>MATH 440.1</td>
                        <td>Time Series Analysis</td>
                        <td>3</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[6]" value="MATH 440.1: Time Series Analysis 3" />
                        </td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>MATH 460.1</td>
                        <td>System Programming</td>
                        <td>3</td>
                        <td class="checkbox">
                            <input type="checkbox" name="choice[7]" value="CSC 460.1: System Programming 3" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- button to submit selections -->
            <button type="submit" name="save">SUBMIT</button>
        </form>
    </div>

    <script>
        //use js to apply animation when user opens page
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                } 
            });
        });

        const hiddenElements = document.querySelectorAll(".hidden");
        hiddenElements.forEach((el) => observer.observe(el));
    </script>
</body>

</html>