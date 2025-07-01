<?php
// Include config for database & SELECT
include "../PHP_Project/select.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Registration Report</title>
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
            min-height: 50rem;
        }

        .Course-report {
            background: linear-gradient(-45deg, #ff0, #fff, #f0f);
            /* using width="100%" to fix color line divisions */
            width: 100%;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1.4rem;
        }

        h1 {
            background: linear-gradient(45deg, #6f085a, #c51c53);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .details {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        #Avatar {
            border: 1px solid #ddd;
            border-radius: 50%;
            height: 200px;
            width: 200px;
        }

        .student-details {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(2, 1fr);
            font-size: 1.5rem;
        }

        .student-details b {
            color: #6f085a;
        }

        .update-profile a {
            background: linear-gradient(45deg, #6f085a, #c51c53);
        }

        table,
        th,
        td {
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
            padding: 13px;
        }

        table {
            width: 600px;
            cursor: pointer;
        }

        th {
            background-color: blue;
            color: #fff;
        }

        td {
            color: #000;
            font-size: 18px;
            background-color: #ddd;
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


        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
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
            transform: translateY(-100%);
            transition: all 1s;
        }

        .show {
            opacity: 1;
            filter: blur(0);
            transform: translateX(0);
        }

        @media (max-width: 66rem) {
            .student-details {
                display: grid;
                gap: 1rem;
                grid-template-columns: 1fr;
                place-items: center;
            }

            table {
                width: 400px;
            }

            .logout {
                margin: 2rem 1rem;
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
    <button><a class="logout" href="./logout_student.php">Log Out</a></button>

    <div class="Course-report">
        <!-- header -->
        <h1 class="hidden">Course Registration Report</h1>
        <div class="details hidden">
            <!-- DISPLAYING STUDENT IMAGE -->
            <img src='UploadImageOfStudent/<?= $user_ProfilePicture ?>' alt='Avatar' id='Avatar'>;
            <!-- STUDENT DETAILS -->
            <div class='student-details'>
                <p><b> Matriculation No: </b><?= $user_JAMB_reg_no ?></p>
                <p><b> Level:</b>Year 4</p>
                <p><b> Last Name: </b><?= $user_last_name ?></p>
                <p><b> First Name: </b><?= $user_first_name ?></p>
                <p><b> Gender: </b><?= $user_gender ?></p>
                <p><b> Faculty/Dept: </b><?= $user_faculty_dept ?></p>
            </div>
        </div>

        <div class=" update-profile hidden">
            <!-- button to make changes result -->
            <a class="btn" href="./Update_student_profile.php">UPDATE YOUR PROFILE</a>
        </div>

        <table class="hidden">
            <thead>
                <tr>
                    <th>S/No</th>
                    <th>Course Code | Course Tittle | Credit Unit</th>
                </tr>
            </thead>

            <tbody>
                <?php
                //Viewing result of checkbox
                $query = "SELECT course_of_choice FROM course";
                $connect = mysqli_query($connectLink, $query);
                //checking in database if there is any data or not

                $num =  mysqli_num_rows($connect);

                if ($num > 0) {
                    $i = 1;
                    while ($checkbox = mysqli_fetch_assoc($connect)) {
                        //$values = explode(",", $checkbox);
                        echo "
                <tr>
                    <td>" . $i++ . "</td>
                    <td>" . $checkbox['course_of_choice'] . "</td>
                </tr>
                ";
                    }
                } else {
                    echo "
                        <tr>
                            <td style='color:red'>
                                NONE
                            </td>

                            <td style='color:red'>
                                NO COURSE WAS REGISTERED
                            </td>
                        </tr>
                        ";
                }


                ?>
            </tbody>
        </table>
        <div class="btn-container">
            <!-- button to make changes result -->
            <a class="btn" href="./Course_Registration.php">Edit</a>

            <!-- button to delete result -->
            <a class="btn" href="./Delete_Course.php">Delete</a>

            <!-- button to download result -->
            <!-- <a class="btn" href="./export_course.php">Download</a> -->
        </div>
        <div style='text-align:center'>&copy; Copyright 2019 By Bolaji Bakare</div>
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