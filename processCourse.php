<?php
session_start();
//connecting to database configuration
include '../PHP_Project/DATABASE_Configuration/Database_for_student.php';

if (isset($_POST['save'])) {
    //validating checkbox
    $checked = 0;
    $Options = $_POST['choice'];
    $checked = count($Options);
    if ($checked < 1) {
        $_SESSION['status'] = "check at least one course";
        header("location: ./course_Registration.php");
        //$error = 'check at least one course';
    } elseif ($checked >= 6) {
        $_SESSION['status'] = "Maximum of 6 course allowed only";
        header("location: ./course_Registration.php");
        //$error = 'Maximum of 6 course allowed only';
    } else {
        //using foreach to get multiple checkbox result
        foreach ($Options as $values) {
        //$values = implode(",", $Options);
        $insert_data = "INSERT INTO course (course_of_choice) VALUES ('$values')";
        $run_data = mysqli_query($connectLink, $insert_data);
        //$error = 'Registered successfully';
        }
    }

    //To check if record was stored into database
    if ($run_data) {
        //$_SESSION['status'] = "Course of choice Registered Successfully";
        //Redirect to stored report
        header("location: ./view_course.php");
    } //else {
        //$_SESSION['status'] = "NO Course was Registered";
        //header("location: ./course_Registration.php");
    //}
}
