<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $admin = find_admin_by_username($username);
    if($admin) {

      if(password_verify($password, $admin['hashed_password'])) {
        // password matches
        log_in_admin($admin);
        redirect_to(url_for('/staff/index.php'));
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }

  }

}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
 <link rel="stylesheet" href="<?= url_for('/assets/css/public.style.css'); ?>" >
 <link rel="stylesheet" href="<?= url_for('/assets/css/flexboxgrid.css'); ?>" >

 
 <?php echo display_errors($errors); ?>
  <div class="row" id="login">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <h1>Log<span>in</span></h1>
      <form action="login.php" method="post">
        <p><input type="text" name="username" placeholder="Username" value="<?php echo h($username); ?>"></p>
        <p><input type="password" name="password" placeholder="Password"></p>
        <p><input type="submit" name="submit" value="Login"></p>
      </form>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <img src="<?php echo url_for('assets/uploads/buhari.png'); ?>">
    </div>
  </div>
<?php include(SHARED_PATH . '/public_footer.php'); ?>
