<?php
require 'config/config.php'; // To include config.php file
include("includes/classes/User.php"); // To include User.php file
include("includes/classes/Post.php"); // To include Post.php file
include("includes/classes/Message.php"); // To include Message.php file


// Triggers when session variable for username is set
// It prevents illegal access of index page

if (isset($_SESSION['username'])) {

  $userLoggedIn = $_SESSION['username'];

  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");

  $user = mysqli_fetch_array($user_details_query);
} else {
  header("Location: register.php"); // If not set redirects to register.php
}

?>

<html dir='rtl'>

<head>
  <title>Welcome to Insta..!!</title>

  <!-- Javascript -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/bootbox.min.js"></script>
  <script src="assets/js/buddy.js"></script>
  <script src="assets/js/jquery.jcrop.js"></script>
  <script src="assets/js/jcrop_bits.js"></script>


  <!-- CSS -->

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />

</head>

<body>

  <!-- Navigation Bar -->

  <div class="top_bar">
    <nav class="">

      <!-- Firstname display in navbar -->

      <a href="<?php echo $userLoggedIn; ?>">
        <?php echo $user['first_name']; ?>
      </a>

      <!-- Home -->

      <a href="index.php">
        <i class="fas fa-home"></i>
      </a>

      <!-- Messages -->

      <a href="messages.php">
        <i class="fas fa-comments"></i>
      </a>

      <!-- Friend Requests -->

      <a href="requests.php">
        <i class="fas fa-users"></i>
      </a>

      <!-- Settings -->

      <a href="settings.php">
        <i class="fas fa-cog"></i>
      </a>

      <!-- Logout -->

      <a href="includes/handlers/logout.php">
        <i class="fas fa-sign-out-alt"></i>
      </a>

    </nav>
    <div class="dropdown_data_window" style="height:0px; border:none;"></div>
    <input type="hidden" id="dropdown_data_type" value="">
    <!-- Navbar Logo Section -->
    <div class="logo ">
      <a href="index.php">
        <h4>انستا</h4>
      </a>
    </div>

    <div class="search">
      <form action="search.php" style="margin-right: 100px;" method="GET" name="search_form">
        <input type="text" class="form-control" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">
        <div class="button_holder">
          <img src="assets/images/icons/magnifying_glass.png">
        </div>
      </form>
      <!-- Search Section -->
      <div class="search_results">
      </div>
      <div class="search_results_footer_empty">
      </div>
    </div>
  </div>
  <div class="clear"></div>
  <div class="wrapper">