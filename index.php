<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OLA STATE UNIVERSITY</title>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="style.css" />
    <!-- EXTERNAL JS -->
    <script defer src="script.js"></script>
  </head>
  <body>
    <nav>
      <!-- website logo -->
      <div class="logo">
        <img src="./UploadImageOfStudent/logo.png" alt="logo" />
        <h2>OLA STATE UNIVERSITY</h2>
      </div>

      <!-- Navigation list-->
      <ul class="navbar" id="navbar">
        <li><a href="#">Home</a></li>
        <li><a href="Update_student_profile.php">update</a></li>
        <li><a href="./view_course.php">View</a></li>
      </ul>

      <!-- login and registration button -->
      <div class="loginReg-wrapper">
        <button><a href="Student_registration.php">Register</a></button>
        <button><a href="Login_student.php">Login</a></button>
      </div>

      <!-- Toggle Menu for Mobile friendly device -->
      <button class="toggleBtn" id="toggleIcon">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </button>
    </nav>

    
    <main>
      <h1>Dashboard</h1>
    </main>

    <footer>
      <!-- website logo -->
      <div class="logo">
        <img src="./UploadImageOfStudent/logo.png" alt="logo" />
        <h2>OLA STATE UNIVERSITY</h2>
      </div>
      <!-- copyright -->
      <div style="text-align: center">
        &copy; 2020 - {DateYear.getFullYear()} | Ola state University
      </div>
    </footer>
  </body>
</html>
