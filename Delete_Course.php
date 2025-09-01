<?php
// Include config for database & SELECT
include "./select.php";


//DELETE SELECTED result of checkbox
if (isset($_POST['delete']) && isset($_POST['delete_course_id'])) {
    $id = $_POST['delete_course_id'];
    foreach ($id as $delete_course_by_id) {
        $delete = "DELETE FROM course WHERE id = $delete_course_by_id";
        $run_data = mysqli_query($connectLink, $delete);
    }
    if ($run_data) {
        $added = true;
    } else {
        echo "Data not deleted";
    }
}


//Viewing result of checkbox
$query = "SELECT * FROM course";
$connect = mysqli_query($connectLink, $query);
//checking in database if there is any data or not
$num =  mysqli_num_rows($connect);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delete Registered Course</title>

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


        .form-container {
            background: linear-gradient(-45deg, #ff0, #fff, #f0f);
            /* using width="100%" to fix color line divisions */
            width: 100%;
            min-height: 100%;
            border: none;
            outline: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
            color: #fff;
        }

        td {
            font-size: 18px;
            color: #000;
            background-color: #ddd;
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
            border: 2px solid red;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            translate: -50% -50%;
            cursor: pointer;
            transition: 0.3s all ease;
        }

        .checkbox input:checked::before {
            background-color: red;
            border: 1px solid red;
        }

        .checkbox input:checked::after {
            position: absolute;
            /* content: "\2714"; */
            content: "\f00c";
            font-family: "FontAwesome";
            color: #fff;
        }

        button {
            padding: 0.5rem;
            border-radius: 7px;
            color: #000;
            font-size: 18px;
            font-weight: bold;
            background-color: #48b1df;
        }

        button:hover {
            border-color: red;
            background-color: #fff;
            color: red;
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

        .logout:hover {
            background-color: #48b1df;
            color: #000;
        }

        .logout:active {
            scale: 0.92;
            color: #fff;
            background-color: red;
        }

        .Register-Again {
            margin: 1rem;
            padding: 0.5rem;
            border-radius: 7px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            background-color: rgb(18, 18, 230);
        }

        .Register-Again:hover {
            background-color: #48b1df;
            color: #000;
        }

        .Register-Again:active {
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
        <!-- header -->
        <h1>UNREGISTER COURSE</h1>

        <div class="Course-report">
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

            <!-- Unregister Course -->
            <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST">
                <!-- list of Course-->
                <table class="hidden">
                    <!-- table Title -->
                    <caption>
                        SELECT THE COURSE YOU WANT TO DELETE
                    </caption>

                    <!--Table heading -->
                    <thead>
                        <tr>
                            <th>S/No</th>
                            <th>Course Code | Course Tittle | Credit Unit</th>
                            <!-- button to delete selected checkbox -->
                            <th><button type="submit" name="delete">Delete</button></th>
                        </tr>
                    </thead>

                    <!--Table body -->
                    <tbody>
                        <?php
                        if ($num > 0) {
                            $i = 1;
                            foreach ($connect as $row) {
                        ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>

                                    <td><?= $row['course_of_choice']; ?></td>

                                    <td class="checkbox">
                                        <input type="checkbox" name="delete_course_id[]" value="<?= $row['id']; ?>" />
                                    </td>
                                </tr>

                        <?php

                            }
                        } else {

                            echo "
                        <tr>
                            <td style='color:red'>
                                NONE
                            </td>

                            <td style='color:red; display: flex; flex-direction:column;'>
                                ALL REGISTERED COURSE DELETED
                                <a href='#' class='Register-Again' >Register Again</a> 
                            </td>

                            <td style='color:red'>
                                EMPTY
                            </td>
                        </tr>

                        

                        ";
                        }

                        ?>
                    </tbody>
                </table>
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