<?php
// establish a database connection
$host = '';
$user = '';
$pass = '';
$database = '';
$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();
// check if user is logged in
if (!isset($_SESSION['username'])) {
  header('Location: ../signin'); // redirect to login page if user is not logged in
  exit();
}

// get username from session
$username = $_SESSION['username'];

// fetch data from MySQL database based on the username
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// display the data in input fields
?>
<html lang=en>
   <head>
      <meta charset=UTF-8>
      <meta content="IE=edge"http-equiv=X-UA-Compatible>
      <meta content="width=device-width,initial-scale=1"name=viewport>
      <title>Secure Connect - Edit Data</title>
      <link href="../images/favicon.png" rel=icon>
      <link href="../css/style.css" rel=stylesheet>
      <link rel="stylesheet" href="../css/tailwind.css" />
      <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet" type="text/css" />
   </head>
   <body :class="{'b yn mj': darkMode === true}" x-data="{ page: 'analytics', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }" x-init="
      darkMode = JSON.parse(localStorage.getItem('darkMode'));
      $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))">
      <div class=nh>
         <aside :class="sidebarToggle && 'zf ph'"class="ip -ud-translate-x-full _e _u bv dp f hp l nj oa ou q qo u xr">
            <button class="g bj nj wr xr ni -ud-right-9.5 _k jc pa qh uo vu"@click="sidebarToggle = !sidebarToggle":class="sidebarToggle && 'ga'"><span class="jc h bf cg sd"><span class="g m du-block vc yd"><span class="jc cs fp gp uj zh q td cf h r ya yo":class="{ 'df zo': !sidebarToggle }"></span> <span class="jc cs fp gp uj zh q td cf h r ya _o":class="{ 'df gw': !sidebarToggle }"></span> <span class="jc cs fp gp uj zh q td cf h r ya ap":class="{ 'df bp': !sidebarToggle }"></span> </span><span class="g m du-block vc yd _f"><span class="g jc cs fp gp uj zh ef ha r vc zo":class="{ 'ud yo': !sidebarToggle }"></span> <span class="g yd cs fp gp gw ia jc q td uj zh":class="{ 'ud hw': !sidebarToggle }"></span></span></span></button>
            <nav class="ru fv gc ml rl"x-data="{selected: 'Dashboard'}"x-init="
               selected = JSON.parse(localStorage.getItem('selected'));
               $watch('selected', value => localStorage.setItem('selected', JSON.stringify(value)))">
               <ul class="lc hg bh">
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq" href="../dashboard/">
                        <i class="fa-regular fa-sitemap"></i> Sites
                     </a>
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq" href="../profile/">
                        <i class="fa-regular fa-user"></i> Profile
                     </a>
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq eo oj">
                        <i class="fa-regular fa-user-pen"></i> Edit Data
                     </a>
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq" href="../document-upload/">
                        <i class="fa-solid fa-file-arrow-up"></i> Upload Documents
                     </a>
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq" href="../verification/">
                        <i class="fa-regular fa-badge-check"></i> Verification
                     </a>
                  <li>
                     <a class="lc mg qh h nr dp gp rl sg un _q nl qq" href="../logout/">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                     </a>
               </ul>
            </nav>
         </aside>
         <header :class="{ 'iw' : stickyMenu }"@scroll.window="stickyMenu = (window.pageYOffset > 20) ? true : false"class="lc dp f hp nj oa q r xr yd">
            <div class="lc mg ml qo rl fv rv yu">
               <a class="lc mg zg"href=index.html>
                  <img alt=Logo src="../images/logo/icon-light.svg" class=vr> <img alt=Logo src=../images/logo/icon-dark.svg class="pc ur"> 
                  <span class="gs bc lo pc tu">
                     <svg fill=none  class=hk width="120" viewBox="0 0 90 37.5" height="50" preserveAspectRatio="xMidYMid meet"><defs><g/></defs><g  fill=""><g transform="translate(12.343388, 15.627824)"><g><path d="M 6.75 -15.578125 C 7.582031 -15.578125 8.394531 -15.457031 9.1875 -15.21875 C 9.976562 -14.976562 10.5625 -14.738281 10.9375 -14.5 L 11.5 -14.125 L 10.09375 -11.34375 C 9.976562 -11.425781 9.820312 -11.523438 9.625 -11.640625 C 9.425781 -11.753906 9.054688 -11.910156 8.515625 -12.109375 C 7.972656 -12.304688 7.460938 -12.40625 6.984375 -12.40625 C 6.410156 -12.40625 5.960938 -12.28125 5.640625 -12.03125 C 5.328125 -11.789062 5.171875 -11.457031 5.171875 -11.03125 C 5.171875 -10.820312 5.242188 -10.628906 5.390625 -10.453125 C 5.546875 -10.273438 5.800781 -10.082031 6.15625 -9.875 C 6.519531 -9.664062 6.835938 -9.5 7.109375 -9.375 C 7.378906 -9.257812 7.796875 -9.078125 8.359375 -8.828125 C 9.347656 -8.410156 10.191406 -7.835938 10.890625 -7.109375 C 11.585938 -6.390625 11.9375 -5.570312 11.9375 -4.65625 C 11.9375 -3.78125 11.78125 -3.015625 11.46875 -2.359375 C 11.15625 -1.703125 10.722656 -1.1875 10.171875 -0.8125 C 9.617188 -0.445312 9.007812 -0.175781 8.34375 0 C 7.675781 0.1875 6.953125 0.28125 6.171875 0.28125 C 5.503906 0.28125 4.847656 0.210938 4.203125 0.078125 C 3.566406 -0.0546875 3.03125 -0.222656 2.59375 -0.421875 C 2.164062 -0.628906 1.773438 -0.832031 1.421875 -1.03125 C 1.078125 -1.226562 0.828125 -1.398438 0.671875 -1.546875 L 0.421875 -1.75 L 2.171875 -4.671875 C 2.316406 -4.546875 2.519531 -4.382812 2.78125 -4.1875 C 3.039062 -4 3.5 -3.742188 4.15625 -3.421875 C 4.820312 -3.109375 5.410156 -2.953125 5.921875 -2.953125 C 7.390625 -2.953125 8.125 -3.453125 8.125 -4.453125 C 8.125 -4.660156 8.070312 -4.851562 7.96875 -5.03125 C 7.863281 -5.207031 7.675781 -5.382812 7.40625 -5.5625 C 7.144531 -5.75 6.910156 -5.894531 6.703125 -6 C 6.503906 -6.101562 6.171875 -6.265625 5.703125 -6.484375 C 5.234375 -6.703125 4.890625 -6.863281 4.671875 -6.96875 C 3.742188 -7.425781 3.023438 -8 2.515625 -8.6875 C 2.015625 -9.375 1.765625 -10.113281 1.765625 -10.90625 C 1.765625 -12.28125 2.269531 -13.398438 3.28125 -14.265625 C 4.289062 -15.140625 5.445312 -15.578125 6.75 -15.578125 Z M 6.75 -15.578125 "/></g></g></g><g  fill=""><g transform="translate(24.80388, 15.627824)"><g><path d="M 10.734375 -4.296875 L 3.84375 -4.296875 C 3.84375 -3.628906 4.054688 -3.132812 4.484375 -2.8125 C 4.921875 -2.5 5.390625 -2.34375 5.890625 -2.34375 C 6.429688 -2.34375 6.851562 -2.410156 7.15625 -2.546875 C 7.46875 -2.691406 7.820312 -2.972656 8.21875 -3.390625 L 10.59375 -2.203125 C 9.601562 -0.546875 7.957031 0.28125 5.65625 0.28125 C 4.21875 0.28125 2.984375 -0.207031 1.953125 -1.1875 C 0.929688 -2.175781 0.421875 -3.363281 0.421875 -4.75 C 0.421875 -6.132812 0.929688 -7.320312 1.953125 -8.3125 C 2.984375 -9.300781 4.21875 -9.796875 5.65625 -9.796875 C 7.164062 -9.796875 8.390625 -9.359375 9.328125 -8.484375 C 10.273438 -7.609375 10.75 -6.363281 10.75 -4.75 C 10.75 -4.53125 10.742188 -4.378906 10.734375 -4.296875 Z M 3.9375 -6.125 L 7.546875 -6.125 C 7.472656 -6.613281 7.273438 -6.988281 6.953125 -7.25 C 6.640625 -7.519531 6.238281 -7.65625 5.75 -7.65625 C 5.207031 -7.65625 4.773438 -7.515625 4.453125 -7.234375 C 4.128906 -6.953125 3.957031 -6.582031 3.9375 -6.125 Z M 3.9375 -6.125 "/></g></g></g><g  fill=""><g transform="translate(35.984939, 15.627824)"><g><path d="M 6.171875 -7.109375 C 5.554688 -7.109375 5.023438 -6.878906 4.578125 -6.421875 C 4.128906 -5.960938 3.90625 -5.410156 3.90625 -4.765625 C 3.90625 -4.109375 4.128906 -3.550781 4.578125 -3.09375 C 5.023438 -2.632812 5.554688 -2.40625 6.171875 -2.40625 C 6.472656 -2.40625 6.753906 -2.441406 7.015625 -2.515625 C 7.285156 -2.597656 7.484375 -2.675781 7.609375 -2.75 L 7.765625 -2.859375 L 8.890625 -0.578125 C 8.796875 -0.515625 8.671875 -0.4375 8.515625 -0.34375 C 8.367188 -0.25 8.019531 -0.125 7.46875 0.03125 C 6.914062 0.195312 6.320312 0.28125 5.6875 0.28125 C 4.289062 0.28125 3.0625 -0.207031 2 -1.1875 C 0.945312 -2.175781 0.421875 -3.359375 0.421875 -4.734375 C 0.421875 -6.117188 0.945312 -7.304688 2 -8.296875 C 3.0625 -9.296875 4.289062 -9.796875 5.6875 -9.796875 C 6.320312 -9.796875 6.90625 -9.71875 7.4375 -9.5625 C 7.96875 -9.414062 8.34375 -9.269531 8.5625 -9.125 L 8.890625 -8.90625 L 7.765625 -6.65625 C 7.359375 -6.957031 6.828125 -7.109375 6.171875 -7.109375 Z M 6.171875 -7.109375 "/></g></g></g><g  fill=""><g transform="translate(45.089246, 15.627824)"><g><path d="M 4.203125 -9.515625 L 4.203125 -4.984375 C 4.203125 -4.046875 4.34375 -3.378906 4.625 -2.984375 C 4.914062 -2.585938 5.398438 -2.390625 6.078125 -2.390625 C 6.765625 -2.390625 7.25 -2.585938 7.53125 -2.984375 C 7.8125 -3.378906 7.953125 -4.046875 7.953125 -4.984375 L 7.953125 -9.515625 L 11.234375 -9.515625 L 11.234375 -4.1875 C 11.234375 -2.601562 10.820312 -1.460938 10 -0.765625 C 9.175781 -0.0664062 7.867188 0.28125 6.078125 0.28125 C 4.285156 0.28125 2.976562 -0.0664062 2.15625 -0.765625 C 1.332031 -1.460938 0.921875 -2.601562 0.921875 -4.1875 L 0.921875 -9.515625 Z M 4.203125 -9.515625 "/></g></g></g><g  fill=""><g transform="translate(57.253046, 15.627824)"><g><path d="M 1.109375 0 L 1.109375 -9.515625 L 4.390625 -9.515625 L 4.390625 -8.140625 L 4.4375 -8.140625 C 4.457031 -8.191406 4.492188 -8.253906 4.546875 -8.328125 C 4.609375 -8.398438 4.726562 -8.53125 4.90625 -8.71875 C 5.09375 -8.90625 5.289062 -9.070312 5.5 -9.21875 C 5.71875 -9.363281 5.992188 -9.492188 6.328125 -9.609375 C 6.660156 -9.734375 7 -9.796875 7.34375 -9.796875 C 7.695312 -9.796875 8.046875 -9.742188 8.390625 -9.640625 C 8.742188 -9.546875 9 -9.445312 9.15625 -9.34375 L 9.421875 -9.203125 L 8.046875 -6.421875 C 7.640625 -6.765625 7.070312 -6.9375 6.34375 -6.9375 C 5.945312 -6.9375 5.601562 -6.847656 5.3125 -6.671875 C 5.03125 -6.503906 4.832031 -6.296875 4.71875 -6.046875 C 4.601562 -5.796875 4.519531 -5.582031 4.46875 -5.40625 C 4.414062 -5.238281 4.390625 -5.101562 4.390625 -5 L 4.390625 0 Z M 1.109375 0 "/></g></g></g><g  fill=""><g transform="translate(66.487157, 15.627824)"><g><path d="M 10.734375 -4.296875 L 3.84375 -4.296875 C 3.84375 -3.628906 4.054688 -3.132812 4.484375 -2.8125 C 4.921875 -2.5 5.390625 -2.34375 5.890625 -2.34375 C 6.429688 -2.34375 6.851562 -2.410156 7.15625 -2.546875 C 7.46875 -2.691406 7.820312 -2.972656 8.21875 -3.390625 L 10.59375 -2.203125 C 9.601562 -0.546875 7.957031 0.28125 5.65625 0.28125 C 4.21875 0.28125 2.984375 -0.207031 1.953125 -1.1875 C 0.929688 -2.175781 0.421875 -3.363281 0.421875 -4.75 C 0.421875 -6.132812 0.929688 -7.320312 1.953125 -8.3125 C 2.984375 -9.300781 4.21875 -9.796875 5.65625 -9.796875 C 7.164062 -9.796875 8.390625 -9.359375 9.328125 -8.484375 C 10.273438 -7.609375 10.75 -6.363281 10.75 -4.75 C 10.75 -4.53125 10.742188 -4.378906 10.734375 -4.296875 Z M 3.9375 -6.125 L 7.546875 -6.125 C 7.472656 -6.613281 7.273438 -6.988281 6.953125 -7.25 C 6.640625 -7.519531 6.238281 -7.65625 5.75 -7.65625 C 5.207031 -7.65625 4.773438 -7.515625 4.453125 -7.234375 C 4.128906 -6.953125 3.957031 -6.582031 3.9375 -6.125 Z M 3.9375 -6.125 "/></g></g></g><g  fill=""><g transform="translate(5.819973, 34.605033)"><g><path d="M 9.25 -3.15625 C 9.78125 -3.15625 10.296875 -3.234375 10.796875 -3.390625 C 11.296875 -3.554688 11.664062 -3.710938 11.90625 -3.859375 L 12.265625 -4.09375 L 13.75 -1.125 C 13.695312 -1.09375 13.625 -1.046875 13.53125 -0.984375 C 13.445312 -0.921875 13.25 -0.804688 12.9375 -0.640625 C 12.625 -0.472656 12.285156 -0.328125 11.921875 -0.203125 C 11.566406 -0.078125 11.097656 0.03125 10.515625 0.125 C 9.929688 0.226562 9.332031 0.28125 8.71875 0.28125 C 7.289062 0.28125 5.941406 -0.0664062 4.671875 -0.765625 C 3.398438 -1.460938 2.375 -2.421875 1.59375 -3.640625 C 0.8125 -4.867188 0.421875 -6.195312 0.421875 -7.625 C 0.421875 -8.695312 0.648438 -9.726562 1.109375 -10.71875 C 1.566406 -11.707031 2.175781 -12.550781 2.9375 -13.25 C 3.695312 -13.957031 4.582031 -14.519531 5.59375 -14.9375 C 6.613281 -15.363281 7.65625 -15.578125 8.71875 -15.578125 C 9.707031 -15.578125 10.617188 -15.457031 11.453125 -15.21875 C 12.285156 -14.988281 12.875 -14.753906 13.21875 -14.515625 L 13.75 -14.171875 L 12.265625 -11.203125 C 12.171875 -11.273438 12.035156 -11.363281 11.859375 -11.46875 C 11.691406 -11.570312 11.347656 -11.707031 10.828125 -11.875 C 10.304688 -12.050781 9.78125 -12.140625 9.25 -12.140625 C 8.414062 -12.140625 7.660156 -12.003906 6.984375 -11.734375 C 6.316406 -11.460938 5.789062 -11.101562 5.40625 -10.65625 C 5.019531 -10.21875 4.722656 -9.738281 4.515625 -9.21875 C 4.304688 -8.707031 4.203125 -8.1875 4.203125 -7.65625 C 4.203125 -6.5 4.640625 -5.457031 5.515625 -4.53125 C 6.390625 -3.613281 7.632812 -3.15625 9.25 -3.15625 Z M 9.25 -3.15625 "/></g></g></g><g  fill=""><g transform="translate(19.782383, 34.605033)"><g><path d="M 2 -1.125 C 0.945312 -2.070312 0.421875 -3.28125 0.421875 -4.75 C 0.421875 -6.21875 0.972656 -7.425781 2.078125 -8.375 C 3.179688 -9.320312 4.539062 -9.796875 6.15625 -9.796875 C 7.75 -9.796875 9.09375 -9.316406 10.1875 -8.359375 C 11.28125 -7.410156 11.828125 -6.207031 11.828125 -4.75 C 11.828125 -3.289062 11.289062 -2.085938 10.21875 -1.140625 C 9.15625 -0.191406 7.800781 0.28125 6.15625 0.28125 C 4.445312 0.28125 3.0625 -0.1875 2 -1.125 Z M 4.546875 -6.359375 C 4.117188 -5.941406 3.90625 -5.40625 3.90625 -4.75 C 3.90625 -4.09375 4.109375 -3.554688 4.515625 -3.140625 C 4.929688 -2.722656 5.472656 -2.515625 6.140625 -2.515625 C 6.785156 -2.515625 7.3125 -2.722656 7.71875 -3.140625 C 8.132812 -3.566406 8.34375 -4.101562 8.34375 -4.75 C 8.34375 -5.40625 8.128906 -5.941406 7.703125 -6.359375 C 7.273438 -6.773438 6.753906 -6.984375 6.140625 -6.984375 C 5.503906 -6.984375 4.972656 -6.773438 4.546875 -6.359375 Z M 4.546875 -6.359375 "/></g></g></g><g  fill=""><g transform="translate(32.038902, 34.605033)"><g><path d="M 1.109375 0 L 1.109375 -9.515625 L 4.390625 -9.515625 L 4.390625 -8.515625 L 4.4375 -8.515625 C 5.289062 -9.367188 6.195312 -9.796875 7.15625 -9.796875 C 7.625 -9.796875 8.085938 -9.734375 8.546875 -9.609375 C 9.015625 -9.484375 9.460938 -9.289062 9.890625 -9.03125 C 10.316406 -8.769531 10.660156 -8.398438 10.921875 -7.921875 C 11.191406 -7.453125 11.328125 -6.898438 11.328125 -6.265625 L 11.328125 0 L 8.046875 0 L 8.046875 -5.375 C 8.046875 -5.875 7.890625 -6.304688 7.578125 -6.671875 C 7.265625 -7.046875 6.851562 -7.234375 6.34375 -7.234375 C 5.84375 -7.234375 5.390625 -7.039062 4.984375 -6.65625 C 4.585938 -6.269531 4.390625 -5.84375 4.390625 -5.375 L 4.390625 0 Z M 1.109375 0 "/></g></g></g><g  fill=""><g transform="translate(44.295421, 34.605033)"><g><path d="M 1.109375 0 L 1.109375 -9.515625 L 4.390625 -9.515625 L 4.390625 -8.515625 L 4.4375 -8.515625 C 5.289062 -9.367188 6.195312 -9.796875 7.15625 -9.796875 C 7.625 -9.796875 8.085938 -9.734375 8.546875 -9.609375 C 9.015625 -9.484375 9.460938 -9.289062 9.890625 -9.03125 C 10.316406 -8.769531 10.660156 -8.398438 10.921875 -7.921875 C 11.191406 -7.453125 11.328125 -6.898438 11.328125 -6.265625 L 11.328125 0 L 8.046875 0 L 8.046875 -5.375 C 8.046875 -5.875 7.890625 -6.304688 7.578125 -6.671875 C 7.265625 -7.046875 6.851562 -7.234375 6.34375 -7.234375 C 5.84375 -7.234375 5.390625 -7.039062 4.984375 -6.65625 C 4.585938 -6.269531 4.390625 -5.84375 4.390625 -5.375 L 4.390625 0 Z M 1.109375 0 "/></g></g></g><g  fill=""><g transform="translate(56.55194, 34.605033)"><g><path d="M 10.734375 -4.296875 L 3.84375 -4.296875 C 3.84375 -3.628906 4.054688 -3.132812 4.484375 -2.8125 C 4.921875 -2.5 5.390625 -2.34375 5.890625 -2.34375 C 6.429688 -2.34375 6.851562 -2.410156 7.15625 -2.546875 C 7.46875 -2.691406 7.820312 -2.972656 8.21875 -3.390625 L 10.59375 -2.203125 C 9.601562 -0.546875 7.957031 0.28125 5.65625 0.28125 C 4.21875 0.28125 2.984375 -0.207031 1.953125 -1.1875 C 0.929688 -2.175781 0.421875 -3.363281 0.421875 -4.75 C 0.421875 -6.132812 0.929688 -7.320312 1.953125 -8.3125 C 2.984375 -9.300781 4.21875 -9.796875 5.65625 -9.796875 C 7.164062 -9.796875 8.390625 -9.359375 9.328125 -8.484375 C 10.273438 -7.609375 10.75 -6.363281 10.75 -4.75 C 10.75 -4.53125 10.742188 -4.378906 10.734375 -4.296875 Z M 3.9375 -6.125 L 7.546875 -6.125 C 7.472656 -6.613281 7.273438 -6.988281 6.953125 -7.25 C 6.640625 -7.519531 6.238281 -7.65625 5.75 -7.65625 C 5.207031 -7.65625 4.773438 -7.515625 4.453125 -7.234375 C 4.128906 -6.953125 3.957031 -6.582031 3.9375 -6.125 Z M 3.9375 -6.125 "/></g></g></g><g  fill=""><g transform="translate(67.733, 34.605033)"><g><path d="M 6.171875 -7.109375 C 5.554688 -7.109375 5.023438 -6.878906 4.578125 -6.421875 C 4.128906 -5.960938 3.90625 -5.410156 3.90625 -4.765625 C 3.90625 -4.109375 4.128906 -3.550781 4.578125 -3.09375 C 5.023438 -2.632812 5.554688 -2.40625 6.171875 -2.40625 C 6.472656 -2.40625 6.753906 -2.441406 7.015625 -2.515625 C 7.285156 -2.597656 7.484375 -2.675781 7.609375 -2.75 L 7.765625 -2.859375 L 8.890625 -0.578125 C 8.796875 -0.515625 8.671875 -0.4375 8.515625 -0.34375 C 8.367188 -0.25 8.019531 -0.125 7.46875 0.03125 C 6.914062 0.195312 6.320312 0.28125 5.6875 0.28125 C 4.289062 0.28125 3.0625 -0.207031 2 -1.1875 C 0.945312 -2.175781 0.421875 -3.359375 0.421875 -4.734375 C 0.421875 -6.117188 0.945312 -7.304688 2 -8.296875 C 3.0625 -9.296875 4.289062 -9.796875 5.6875 -9.796875 C 6.320312 -9.796875 6.90625 -9.71875 7.4375 -9.5625 C 7.96875 -9.414062 8.34375 -9.269531 8.5625 -9.125 L 8.890625 -8.90625 L 7.765625 -6.65625 C 7.359375 -6.957031 6.828125 -7.109375 6.171875 -7.109375 Z M 6.171875 -7.109375 "/></g></g></g><g  fill=""><g transform="translate(76.837307, 34.605033)"><g><path d="M 1.671875 -9.515625 L 1.671875 -13.0625 L 4.953125 -13.0625 L 4.953125 -9.515625 L 6.953125 -9.515625 L 6.953125 -7.015625 L 4.953125 -7.015625 L 4.953125 -3.984375 C 4.953125 -3.109375 5.195312 -2.671875 5.6875 -2.671875 C 5.8125 -2.671875 5.941406 -2.691406 6.078125 -2.734375 C 6.210938 -2.785156 6.320312 -2.835938 6.40625 -2.890625 L 6.515625 -2.96875 L 7.328125 -0.3125 C 6.617188 0.0820312 5.816406 0.28125 4.921875 0.28125 C 4.296875 0.28125 3.757812 0.171875 3.3125 -0.046875 C 2.875 -0.265625 2.539062 -0.554688 2.3125 -0.921875 C 2.082031 -1.285156 1.914062 -1.664062 1.8125 -2.0625 C 1.71875 -2.46875 1.671875 -2.898438 1.671875 -3.359375 L 1.671875 -7.015625 L 0.296875 -7.015625 L 0.296875 -9.515625 Z M 1.671875 -9.515625 "/></g></g></g></svg>
                  </span>
               </a>
            </div>
            <div class="lc mg ml qo rl 2xl:ud-px-11 _s hu og xf">
               <div class="pc rs">

               </div>
               <div class="lc mg _g">
                  <ul class="lc mg vg">
                     <li><label class="jc h ua"><input class="g yd vc cg oo r ra ua":value=darkMode @change="darkMode = !darkMode" type=checkbox> <img alt=Sun src=../images/icon/icon-sun.svg class=vr> <img alt=Moon src=../images/icon/icon-moon.svg class="pc ur"></label>
                  </ul>
                  <div class=h x-data="{ dropdownOpen: false }"@click.outside="dropdownOpen = false">
                     <a class="lc mg vg"href=index.html# @click.prevent="dropdownOpen = ! dropdownOpen">
                        <span class="pc tu in"><span class="mn un gs jc zn"><?php echo $row['name']; ?></span> <span class="jc nn"><?php echo $row['username']; ?></span> </span><img src="<?php echo $row['photo']; ?>" width="50" height="50">
                     </a>

                  </div>
               </div>
            </div>
         </header>
         <main class="gv hm hv">
            <div class="2xl:ud-p-11 bu sk">
               <div class="yb ot 2xl:ud-mt-10">
                  <h4 class="gs zn jn tn xb">Edit Data</h4>
                  <p class="mn kb qu">Edit the Details which you have entered...

                  <form method="post" action="../../process/update.php">

                  <div class="rh bj ni nj wr xr">
                     <div class="nf oh">

                     <div class="tk ">
                        <h3 class="un kn zn gs">Details</h3>
                     </div>


                     <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Name</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Name" name="name" id="name" value="<?php echo $row['name']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-regular fa-input-text"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Username</label>
                                 <div class="h">
                                    <input type="text" readonly name="username" id="username" value="<?php echo $row['username']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-user"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Email</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Email ID" name="email" id="email" value="<?php echo $row['email']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-at"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>


                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Date of Birth</label>
                                 <div class="h">
                                    <input type="date" name="dob" id="dob" value="<?php echo $row['dob']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                              <h3 class="un kn zn gs">Contact Number</h3>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Country Code</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Country Code" name="cc" id="cc" value="<?php echo $row['cc']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-plus"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Phone Number</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Phone Number" name="phone" id="phone" value="<?php echo $row['phone']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-phone"></i>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                              <h3 class="un kn zn gs">Address</h3>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Door No.</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Door No." name="dno" id="dno" value="<?php echo $row['dno']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-door-open"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Street</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Street" name="street" id="street" value="<?php echo $row['street']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-sharp fa-solid fa-road"></i>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">City</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your City" name="city" id="city" value="<?php echo $row['city']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-regular fa-tree-city"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">State</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your State" name="state" id="state" value="<?php echo $row['state']; ?>"  class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-city"></i>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>


                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Country</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Country" name="country" id="country" value="<?php echo $row['country']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-flag"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>
                     
                        <div class="tk ti bj wr">
                              <h3 class="un kn zn gs">Payments</h3>
                        </div>


                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Card Number</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your Card Number" name="cardno" id="cardno"  value="<?php echo $row['cardno']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-regular fa-credit-card"></i>
                                    </span>
                                 </div>
                              </div>
                              <div class="yd wu/2 rl">
                                 <div class="h">
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="tk ti bj wr">
                           <div class="-ud-mx-4 lc jg">
                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">CVV</label>
                                 <div class="h">
                                    <input type="text" placeholder="Enter your CVV" name="cvv" id="cvv"  value="<?php echo $row['cvv']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-lock"></i>
                                    </span>
                                 </div>
                              </div>

                              <div class="yd wu/2 rl">
                                 <label class="fb jc un zn gs">Expiry Date</label>
                                 <div class="h">
                                    <input type="month" name="expdate" id="expdate" value="<?php echo $row['expdate']; ?>" class="yd qh ni bj yk an zn vo xo fr kr lr mr">
                                    <span class="g j/2 x -ud-translate-y-1/2">
                                       <i class="fa-solid fa-calendar-week"></i>
                                    </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tk ti bj wr">
                           <button type="submit" style="background-color: rgb(112 131 245/var(--tw-bg-opacity));padding-left: 2.75rem;padding-right: 2.75rem;padding-top: 14px;padding-bottom: 14px; font-weight: 500;font-size: 1rem;line-height: 1.5rem; color: rgb(255 255 255/var(--tw-text-opacity)); border-radius: .375rem;">Save</button>
                        </div>
                  </form>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </main>
      </div>
      <script defer src="../js/bundle.js"></script>
      </body></html>