<?php
session_start(); // Start a new session or resume an existing session

if (isset($_SESSION['username'])) {
  // If the user is already logged in, redirect to the dashboard page
  header('Location: ../dashboard');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // If the form has been submitted, process the registration attempt

  // Get the form input values
  $name = trim($_POST['name']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $email = trim($_POST['email']);
  $photo = "https://secureconnect.techmedok.com/images/user.png";

  // Validate the input values
  if (empty($name) || empty($username) || empty($password) || empty($confirm_password) || empty($email)) {
    $error = "Please enter all required fields.";
  } else if ($password != $confirm_password) {
    $error = "Passwords do not match.";
  } else {
    // Connect to the database (replace with your own database credentials)
    $host = "";
    $dbname = "";
    $user = "";
    $password = "";
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    // Check if the username already exists in the users table
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(array(':username' => $username));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the email already exists in the users table
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(array(':email' => $email));
    $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      // If the username already exists, display an error message
      $error = "Username already taken.";
    } else if ($existing_user) {
      // If the email already exists, display an error message
      $error = "Email already registered.";
    } else {
      // If the username and email are available, insert a new record into the users table and create a session
      
      $stmt = $db->prepare("INSERT INTO users (name, username, password, email, photo) VALUES (:name, :username, :password, :email, :photo)");
      $stmt->execute(array(':name' => $name, ':username' => $username, ':password' => sha1($password), ':email' => $email, ':photo' => $photo));

      $status= "READY";
      $sql2 = "INSERT INTO verification (username, status) VALUES (:username, :status)";

// Prepare the statement
$stmt = $db->prepare($sql2);

// Bind parameters
$stmt->bindParam(':username', $username);
$stmt->bindParam(':status', $status);
$stmt->execute();

      // Set the table name
      $tablename = "user_" . $username;

      // Generate the SQL command
      $sql2 = "CREATE TABLE " . $tablename . " (
         id INT PRIMARY KEY AUTO_INCREMENT,
         sitename varchar(255),
         siteurl varchar(255),
         siteid varchar(255),
         date DATE,
         name varchar(50),
         email varchar(50),
         dno varchar(10),
         street varchar(25),
         city varchar(25),
         state varchar(25),
         country varchar(25),
         cc smallint,
         phone bigint,
         dob date,
         cardno bigint,
         cvv smallint,
         expdate varchar(25),
         photo varchar(255),
         aadhar varchar(255),
         license varchar(255),
         pan varchar(255),
         passport varchar(255)
      )";

      // Prepare the statement
      $stmt = $db->prepare($sql2);
      $stmt->execute();

      $_SESSION['username'] = $username;
      header('Location: ../dashboard');
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="a0">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Connect - Sign Up</title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="../css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../css/animate.css" />
    <link rel="stylesheet" href="../css/glightbox.min.css" />
    <link rel="stylesheet" href="../css/tailwind.css" />
  </head>
  <body class="a1 dark:a2">
    <header class="navbar a3 a4 a5 a6 a7 a8 a1 a9 dark:aa dark:a2">
      <div class="ab ac ad[1400px]">
        <div class="ae af ag">
          <div class="ah ai lg:aj">
            <a href="../" class="ah ad[145px] sm:ad[180px]">
              <img src="../images/logo/logo.svg" alt="logo" class="ah dark:ak" />
              <img src="../images/logo/logo-white.svg" alt="logo" class="ak dark:ah" />
            </a>
          </div>
          <button class="navbarOpen a3 al am/2 a6 ae an ao ap/2 aq af ar as[6px] at lg:ak">
            <span class="ah au[2px] av a2 dark:a1"></span>
            <span class="ah au[2px] av a2 dark:a1"></span>
            <span class="ah au[2px] av a2 dark:a1"></span>
          </button>
          <div class="menu-wrapper ac ak ag lg:ae">
            <button class="navbarClose aw ax ay az[9999] ae an ao aq af ar at lg:ak">
              <span class="ah au[2px] av aA a2 dark:a1"></span>
              <span class="aB[2px] ah au[2px] av aC a2 dark:a1"></span>
            </button>
            <nav class="aw a4 a5 az[999] ae aD a7 af ar a1 aE aF aG dark:a2 dark:aE lg:aH lg:aI lg:aJ lg:aK lg:aL lg:dark:aK">
              <ul class="af aM lg:ae lg:aN lg:aO xl:aP">
                <li class="menu-item">
                  <a href="index.html#features" class="menu-scroll aQ af aR aS aT hover:aU dark:aV dark:hover:aU lg:aW"> Features </a>
                </li>
                <li class="menu-item">
                  <a href="index.html#about" class="menu-scroll aQ af aR aS aT hover:aU dark:aV dark:hover:aU lg:aW"> About </a>
                </li>
                <li class="menu-item">
                  <a href="index.html#work-process" class="menu-scroll aQ af aR aS aT hover:aU dark:aV dark:hover:aU lg:aW"> How It Work </a>
                </li>
                <li class="menu-item">
                  <a href="index.html#support" class="menu-scroll aQ af aR aS aT hover:aU dark:aV dark:hover:aU lg:aW"> Support </a>
                </li>
                <li class="submenu-item menu-item aX ac">
                  <a href="javascript:void(0)" class="submenu-taggler aQ af aR aS aT hover:aU group-hover:aU dark:aV dark:hover:aU lg:aW"> Pages <span class="aY">
                      <svg width="14" height="8" viewBox="0 0 14 8" class="aZ">
                        <path d="M6.54564 5.09128L11.6369 0L13.0913 1.45436L6.54564 8L0 1.45436L1.45436 0L6.54564 5.09128Z" />
                      </svg>
                    </span>
                  </a>
                  <ul class="submenu ak a_ a10 a9 lg:a11 lg:a3 lg:a12[120%] lg:ah lg:a13[250px] lg:a14 lg:a1 lg:a15 lg:a16 lg:a17 lg:a18 lg:a19 lg:group-hover:a1a lg:group-hover:a1b lg:group-hover:a1c dark:lg:a1d dark:lg:a1e[#15182A] lg:dark:a1f">
                    <li>
                      <a href="blog-grid.html" class="a1g aQ af ar aF aR aT hover:aU dark:aV dark:hover:aU"> Blog Grids </a>
                    </li>
                    <li>
                      <a href="blog-details.html" class="a1g aQ af ar aF aR aT hover:aU dark:aV dark:hover:aU"> Blog Details </a>
                    </li>
                    <li>
                      <a href="404.html" class="a1g aQ af ar aF aR aT hover:aU dark:aV dark:hover:aU"> 404 Error </a>
                    </li>
                    <li>
                      <a href="../signin" class="a1g aQ af ar aF aR aT hover:aU dark:aV dark:hover:aU"> Sign In </a>
                    </li>
                    <li>
                      <a href="../signup" class="a1g aQ af ar aF aR aT hover:aU dark:aV dark:hover:aU"> Sign Up </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
          <div class="a1h[60px] ae af a1i lg:a1j">
            <label for="themeSwitcher" class="aQ a1k af" aria-label="themeSwitcher" name="themeSwitcher">
              <input type="checkbox" name="themeSwitcher" id="themeSwitcher" class="a1l" />
              <span class="ak dark:ah">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_420_119)">
                    <path d="M8.40276 5.88205C8.40259 7.05058 8.75048 8.19267 9.40204 9.16268C10.0536 10.1327 10.9793 10.8866 12.0611 11.3284C13.143 11.7701 14.3318 11.8796 15.4761 11.6429C16.6204 11.4062 17.6683 10.8341 18.4861 9.99941V10.0834C18.4861 14.7243 14.7242 18.4862 10.0833 18.4862C5.44247 18.4862 1.68054 14.7243 1.68054 10.0834C1.68054 5.44259 5.44247 1.68066 10.0833 1.68066H10.1673C9.60775 2.22779 9.16333 2.88139 8.86028 3.60295C8.55722 4.32451 8.40166 5.09943 8.40276 5.88205V5.88205ZM3.3611 10.0834C3.36049 11.5833 3.86151 13.0403 4.78444 14.2226C5.70737 15.4049 6.99919 16.2446 8.45437 16.608C9.90954 16.9715 11.4445 16.8379 12.8149 16.2284C14.1854 15.6189 15.3127 14.5686 16.0174 13.2446C14.7632 13.54 13.4543 13.5102 12.215 13.1578C10.9756 12.8054 9.84679 12.1422 8.93568 11.2311C8.02457 10.32 7.36136 9.19119 7.00898 7.95181C6.6566 6.71243 6.62672 5.40357 6.92219 4.1494C5.84629 4.72259 4.94652 5.57759 4.31923 6.62288C3.69194 7.66817 3.36074 8.86438 3.3611 10.0834V10.0834Z" fill="white" />
                  </g>
                  <defs>
                    <clipPath id="clip0_420_119">
                      <rect width="20.1667" height="20.1667" fill="white" />
                    </clipPath>
                  </defs>
                </svg>
              </span>
              <span class="ah dark:ak">
                <svg width="23" height="22" viewBox="0 0 23 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_1_11114)">
                    <path d="M11.5658 16.4998C10.1071 16.4998 8.70815 15.9204 7.6767 14.8889C6.64525 13.8575 6.06579 12.4585 6.06579 10.9998C6.06579 9.54115 6.64525 8.1422 7.6767 7.11075C8.70815 6.0793 10.1071 5.49984 11.5658 5.49984C13.0245 5.49984 14.4234 6.0793 15.4549 7.11075C16.4863 8.1422 17.0658 9.54115 17.0658 10.9998C17.0658 12.4585 16.4863 13.8575 15.4549 14.8889C14.4234 15.9204 13.0245 16.4998 11.5658 16.4998ZM11.5658 14.6665C12.5382 14.6665 13.4709 14.2802 14.1585 13.5926C14.8461 12.9049 15.2325 11.9723 15.2325 10.9998C15.2325 10.0274 14.8461 9.09475 14.1585 8.40711C13.4709 7.71948 12.5382 7.33317 11.5658 7.33317C10.5933 7.33317 9.6607 7.71948 8.97306 8.40711C8.28543 9.09475 7.89912 10.0274 7.89912 10.9998C7.89912 11.9723 8.28543 12.9049 8.97306 13.5926C9.6607 14.2802 10.5933 14.6665 11.5658 14.6665ZM10.6491 0.916504H12.4825V3.6665H10.6491V0.916504ZM10.6491 18.3332H12.4825V21.0832H10.6491V18.3332ZM3.78787 4.51809L5.08404 3.22192L7.02829 5.16617L5.73212 6.46234L3.78787 4.519V4.51809ZM16.1033 16.8335L17.3995 15.5373L19.3437 17.4816L18.0475 18.7778L16.1033 16.8335ZM18.0475 3.221L19.3437 4.51809L17.3995 6.46234L16.1033 5.16617L18.0475 3.22192V3.221ZM5.73212 15.5373L7.02829 16.8335L5.08404 18.7778L3.78787 17.4816L5.73212 15.5373ZM21.6491 10.0832V11.9165H18.8991V10.0832H21.6491ZM4.23245 10.0832V11.9165H1.48245V10.0832H4.23245Z" fill="#181C31" />
                  </g>
                  <defs>
                    <clipPath id="clip0_1_11114">
                      <rect width="22" height="22" fill="white" transform="translate(0.565796)" />
                    </clipPath>
                  </defs>
                </svg>
              </span>
            </label>
            <a href="../signin" class="ak a1m[10px] a1n aR aS aT hover:aU dark:aV dark:hover:aU sm:a1o"> Sign In </a>
            <a href="../signup" class="ak a1p a1q a1m[10px] a1r[30px] aR aS aV hover:a1s sm:a1o"> Sign Up </a>
          </div>
        </div>
      </div>
    </header>
    <main>
      <section class="a1t[150px] a1u[110px] lg:a1t[220px]">
        <div class="ab a1v lg:ad[1250px]">
          <div class="wow fadeInUp a1w a7 ad[520px] a14 a1e[#F8FAFB] a3E a1n a19 dark:a1e[#15182A] dark:a1f sm:a3A[50px]" data-wow-delay=".2s">
            <div class="a2g ae af a2E a1p a3u a8 a1 a3N a1r[10px] dark:aa dark:a2Q">
              <a href="../signin" class="ah a7 a2u a48 aF aR aS aT hover:a1q hover:aV dark:aV"> Sign In </a>
              <a href="../signup" class="ah a7 a2u a1q a48 aF aR aS aV hover:a1s"> Sign Up </a>
            </div>
            <div class="aF">
              <h3 class="a1z[10px] a2p at aT dark:aV sm:a1A[28px]"> Create your account </h3>
              <p class="a1J aR a1B"> It's totally free and super easy <?php if (isset($error)): ?>
              <p style="color: red;"> <?php echo $error; ?> </p> <?php endif; ?> </p>
            </div>
            <form method="POST">
              <div class="a2d">
                <label for="name" class="a1z[10px] ah a2C aT dark:aV"> Name </label>
                <input type="text" name="name" required placeholder="Enter your Name" class="a7 a1p a3u a8 a1 a1D a1n aR aS a1B a45 focus:a46 focus:a4c dark:aa dark:a2 dark:aV dark:focus:a46" />
              </div>
              <div class="a2d">
                <label for="username" class="a1z[10px] ah a2C aT dark:aV"> User Name </label>
                <input type="text" name="username" required placeholder="Enter User Name" class="a7 a1p a3u a8 a1 a1D a1n aR aS a1B a45 focus:a46 focus:a4c dark:aa dark:a2 dark:aV dark:focus:a46" />
              </div>
              <div class="a2d">
                <label for="email" class="a1z[10px] ah a2C aT dark:aV"> Email </label>
                <input type="email" name="email" required placeholder="Enter your Email" class="a7 a1p a3u a8 a1 a1D a1n aR aS a1B a45 focus:a46 focus:a4c dark:aa dark:a2 dark:aV dark:focus:a46" />
              </div>
              <div class="a2n">
                <label for="password" class="a1z[10px] ah a2C aT dark:aV"> Password </label>
                <input type="password" name="password" required placeholder="Enter Password" class="a7 a1p a3u a8 a1 a1D a1n aR aS a1B a45 focus:a46 focus:a4c dark:aa dark:a2 dark:aV dark:focus:a46" />
              </div>
              <div class="a2n">
                <label for="password" class="a1z[10px] ah a2C aT dark:aV"> Confirm Password </label>
                <input type="password" name="confirm_password" required required placeholder="Enter Password again" class="a7 a1p a3u a8 a1 a1D a1n aR aS a1B a45 focus:a46 focus:a4c dark:aa dark:a2 dark:aV dark:focus:a46" />
              </div>
              <div class="a1z[30px]">
                <label for="privacy-policy" class="ae a1k a4f aR a1B">
                  <input type="checkbox" name="privacy-policy" id="privacy-policy" class="keep-signed a1l" />
                  <span class="box a1h[10px] a25[4px] ae au[22px] a7 ad[22px] af ar a4g a33[.7px] a8 a1 dark:aa dark:a2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon ak">
                      <g clip-path="url(#clip0_73_381)">
                        <path d="M6.66649 10.1148L12.7945 3.98608L13.7378 4.92875L6.66649 12.0001L2.42383 7.75742L3.36649 6.81475L6.66649 10.1148Z" fill="white" />
                      </g>
                      <defs>
                        <clipPath id="clip0_73_381">
                          <rect width="16" height="16" fill="white" />
                        </clipPath>
                      </defs>
                    </svg>
                  </span>
                  <p> By creating account means you agree to the <a href="javascript:void(0)" target="_blank" rel="noopener noreferrer" class="aU hover:a3L"> Terms and Conditions </a> , and our <a href="javascript:void(0)" target="_blank" rel="noopener noreferrer" class="aU hover:a3L"> Privacy Policy </a>
                  </p>
                </label>
              </div>
              <button type="submit" class="ae a7 ar a1p a1q a49 aR aS aV hover:a1s"> Sign Up </button>
            </form>
          </div>
        </div>
      </section>
    </main>
    <footer>
      <div class="a1e[#F8FAFB] a1t[95px] a1u[46px] dark:a1e[#15182A]">
        <div class="ab ad[1390px]">
          <div class="a1E ae a1F">
            <div class="a7 a1G lg:a1H/12 xl:a1I/12">
              <div class="wow fadeInUp a1J ad[320px]" data-wow-delay=".2s">
                <a href="../" class="a1x a1o">
                  <img src="../images/logo/logo.svg" alt="logo" class="ah a1y dark:ak" />
                  <img src="../images/logo/logo-white.svg" alt="logo" class="ak a1y dark:ah" />
                </a>
                <p class="aR a1B"> This membership will help you plan and execute a variety of projects. </p>
              </div>
            </div>
            <div class="a7 a1G lg:a1K/12 xl:av/12">
              <div class="a1E ae a1F">
                <div class="a7 a1G sm:a1L/2 md:a1M/12 lg:a1M/12">
                  <div class="wow fadeInUp a1J" data-wow-delay=".25s">
                    <h3 class="a1x a1A[22px] aS aT dark:aV"> Home </h3>
                    <ul class="as[10px]">
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Product </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Pricing </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Business </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Enterprise </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="a7 a1G sm:a1L/2 md:a1N/12 lg:a1N/12">
                  <div class="wow fadeInUp a1J" data-wow-delay=".3s">
                    <h3 class="a1x a1A[22px] aS aT dark:aV"> About Us </h3>
                    <ul class="as[10px]">
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Company </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Leadership </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Careers </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Diversity </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="a7 a1G sm:a1L/2 md:a1N/12 lg:a1N/12">
                  <div class="wow fadeInUp a1J" data-wow-delay=".35s">
                    <h3 class="a1x a1A[22px] aS aT dark:aV"> Resources </h3>
                    <ul class="as[10px]">
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Andy Guide </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Forum </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Support </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> App Directory </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="a7 a1G sm:a1L/2 md:a1H/12 lg:a1H/12">
                  <div class="wow fadeInUp a1J" data-wow-delay=".4s">
                    <h3 class="a1x a1A[22px] aS aT dark:aV"> Tutorial </h3>
                    <ul class="as[10px]">
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> 10 Leadership Styles </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Executive Summary Tips </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> Prevent Team Burnout </a>
                      </li>
                      <li>
                        <a href="javascript:void(0)" class="a1o aR a1B hover:aU"> What are OKRs? </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="wow fadeInUp a1q aW dark:a2" data-wow-delay=".2s">
        <div class="ab ad[1390px]">
          <div class="a1O ae a1F">
            <div class="a1P a7 a1Q lg:a1R lg:a1L/3">
              <p class="a1S aF aR aV lg:a1T lg:a17"> &copy; 2025 Appline. All rights reserved </p>
            </div>
            <div class="a7 a1Q md:a1L/2 lg:a1L/3">
              <div class="a1U ae af ar a1V md:a1W md:a1X lg:ar">
                <a href="javascript:void(0)" class="aV a1Y hover:a1c" name="social icon" aria-label="social icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_53_163)">
                      <path d="M14 13.5H16.5L17.5 9.5H14V7.5C14 6.47 14 5.5 16 5.5H17.5V2.14C17.174 2.097 15.943 2 14.643 2C11.928 2 10 3.657 10 6.7V9.5H7V13.5H10V22H14V13.5Z" fill="white" />
                    </g>
                    <defs>
                      <clipPath id="clip0_53_163">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </a>
                <a href="javascript:void(0)" class="aV a1Y hover:a1c" name="social icon" aria-label="social icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_53_166)">
                      <path d="M22.162 5.65593C21.3986 5.99362 20.589 6.2154 19.76 6.31393C20.6337 5.79136 21.2877 4.96894 21.6 3.99993C20.78 4.48793 19.881 4.82993 18.944 5.01493C18.3146 4.34151 17.4804 3.89489 16.571 3.74451C15.6615 3.59413 14.7279 3.74842 13.9153 4.18338C13.1026 4.61834 12.4564 5.30961 12.0771 6.14972C11.6978 6.98983 11.6067 7.93171 11.818 8.82893C10.1551 8.74558 8.52833 8.31345 7.04329 7.56059C5.55824 6.80773 4.24813 5.75098 3.198 4.45893C2.82629 5.09738 2.63095 5.82315 2.632 6.56193C2.632 8.01193 3.37 9.29293 4.492 10.0429C3.82801 10.022 3.17863 9.84271 2.598 9.51993V9.57193C2.5982 10.5376 2.93237 11.4735 3.54385 12.221C4.15533 12.9684 5.00648 13.4814 5.953 13.6729C5.33661 13.84 4.69031 13.8646 4.063 13.7449C4.32987 14.5762 4.85001 15.3031 5.55059 15.824C6.25118 16.345 7.09713 16.6337 7.97 16.6499C7.10248 17.3313 6.10918 17.8349 5.04688 18.1321C3.98458 18.4293 2.87413 18.5142 1.779 18.3819C3.6907 19.6114 5.9161 20.2641 8.189 20.2619C15.882 20.2619 20.089 13.8889 20.089 8.36193C20.089 8.18193 20.084 7.99993 20.076 7.82193C20.8949 7.2301 21.6016 6.49695 22.163 5.65693L22.162 5.65593Z" fill="white" />
                    </g>
                    <defs>
                      <clipPath id="clip0_53_166">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </a>
                <a href="javascript:void(0)" class="aV a1Y hover:a1c" name="social icon" aria-label="social icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_53_169)">
                      <path d="M6.94 5.00002C6.93974 5.53046 6.72877 6.03906 6.35351 6.41394C5.97825 6.78883 5.46943 6.99929 4.939 6.99902C4.40857 6.99876 3.89996 6.78779 3.52508 6.41253C3.15019 6.03727 2.93973 5.52846 2.94 4.99802C2.94027 4.46759 3.15123 3.95899 3.52649 3.5841C3.90175 3.20922 4.41057 2.99876 4.941 2.99902C5.47143 2.99929 5.98004 3.21026 6.35492 3.58552C6.72981 3.96078 6.94027 4.46959 6.94 5.00002ZM7 8.48002H3V21H7V8.48002ZM13.32 8.48002H9.34V21H13.28V14.43C13.28 10.77 18.05 10.43 18.05 14.43V21H22V13.07C22 6.90002 14.94 7.13002 13.28 10.16L13.32 8.48002Z" fill="white" />
                    </g>
                    <defs>
                      <clipPath id="clip0_53_169">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </a>
                <a href="javascript:void(0)" class="aV a1Y hover:a1c" name="social icon" aria-label="social icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_53_172)">
                      <path d="M7.443 5.3501C8.082 5.3501 8.673 5.4001 9.213 5.5481C9.70302 5.63814 10.1708 5.82293 10.59 6.0921C10.984 6.3391 11.279 6.6861 11.475 7.1311C11.672 7.5761 11.77 8.1211 11.77 8.7141C11.77 9.4071 11.623 10.0001 11.279 10.4451C10.984 10.8911 10.492 11.2861 9.902 11.5831C10.738 11.8311 11.377 12.2761 11.77 12.8691C12.164 13.4631 12.41 14.2051 12.41 15.0461C12.41 15.7391 12.262 16.3321 12.016 16.8271C11.77 17.3221 11.377 17.7671 10.934 18.0641C10.4528 18.3825 9.92084 18.6165 9.361 18.7561C8.771 18.9051 8.181 19.0041 7.591 19.0041H1V5.3501H7.443ZM7.049 10.8901C7.59 10.8901 8.033 10.7421 8.377 10.4951C8.721 10.2481 8.869 9.8021 8.869 9.2581C8.869 8.9611 8.819 8.6641 8.721 8.4671C8.623 8.2691 8.475 8.1201 8.279 7.9721C8.082 7.8731 7.885 7.7741 7.639 7.7251C7.393 7.6751 7.148 7.6751 6.852 7.6751H4V10.8911H7.05L7.049 10.8901ZM7.197 16.7281C7.492 16.7281 7.787 16.6781 8.033 16.6291C8.28138 16.5819 8.51628 16.4805 8.721 16.3321C8.92139 16.1873 9.08903 16.002 9.213 15.7881C9.311 15.5411 9.41 15.2441 9.41 14.8981C9.41 14.2051 9.213 13.7101 8.82 13.3641C8.426 13.0671 7.885 12.9191 7.246 12.9191H4V16.7291H7.197V16.7281ZM16.689 16.6781C17.082 17.0741 17.672 17.2721 18.459 17.2721C19 17.2721 19.492 17.1241 19.885 16.8771C20.279 16.5801 20.525 16.2831 20.623 15.9861H23.033C22.639 17.1731 22.049 18.0141 21.263 18.5581C20.475 19.0531 19.541 19.3501 18.41 19.3501C17.6864 19.3523 16.9688 19.2179 16.295 18.9541C15.6887 18.7266 15.148 18.3529 14.721 17.8661C14.2643 17.4107 13.9267 16.8498 13.738 16.2331C13.492 15.5901 13.393 14.8981 13.393 14.1061C13.393 13.3641 13.492 12.6721 13.738 12.0281C13.9745 11.4082 14.3245 10.8378 14.77 10.3461C15.213 9.9011 15.754 9.5061 16.344 9.2581C17.0007 8.99416 17.7022 8.85969 18.41 8.8621C19.246 8.8621 19.984 9.0111 20.623 9.3571C21.263 9.7031 21.754 10.0991 22.148 10.6931C22.5499 11.2636 22.8494 11.8998 23.033 12.5731C23.131 13.2651 23.18 13.9581 23.131 14.7491H16C16 15.5411 16.295 16.2831 16.689 16.6791V16.6781ZM19.787 11.4841C19.443 11.1381 18.902 10.9401 18.262 10.9401C17.82 10.9401 17.475 11.0391 17.18 11.1871C16.885 11.3361 16.689 11.5341 16.492 11.7321C16.311 11.9234 16.1912 12.1643 16.148 12.4241C16.098 12.6721 16.049 12.8691 16.049 13.0671H20.475C20.377 12.3251 20.131 11.8311 19.787 11.4841ZM15.459 6.2901H20.967V7.6261H15.46V6.2901H15.459Z" fill="white" />
                    </g>
                    <defs>
                      <clipPath id="clip0_53_172">
                        <rect width="24" height="24" fill="white" />
                      </clipPath>
                    </defs>
                  </svg>
                </a>
              </div>
            </div>
            <div class="a7 a1Q md:a1L/2 lg:a1L/3">
              <div class="ae af ar a1Z sm:aN md:a1i lg:a1i">
                <a href="javascript:void(0)" class="aR aV"> Privacy Policy </a>
                <a href="javascript:void(0)" class="aR aV"> Terms and conditions </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <a href="javascript:void(0)" class="back-to-top aw a1_ a20 a21 az[999] ak an ao af ar a1p a1q aV a22 a9 a23 hover:a24">
      <span class="a25[6px] a26 a1N aA a27 a28 a29"></span>
    </a>
    <script src="../js/swiper-bundle.min.js"></script>
    <script src="../js/glightbox.min.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/index.js"></script>
  </body>
</html>