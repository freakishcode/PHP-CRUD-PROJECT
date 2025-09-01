<?php
//adding database configuration file
include './DATABASE_Configuration/Database_for_student.php';

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
