<?php

require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  $admin = [];
  $admin['id'] = $id;
  $admin['first_name'] = isset($_POST['first_name']) ? $_POST['first_name'] : '';
  $admin['last_name'] = isset($_POST['last_name']) ? $_POST['last_name'] : '';
  $admin['email'] = isset($_POST['email']) ? $_POST['email'] : ''; 
  $admin['username'] =isset($_POST['username']) ? $_POST['username'] :'';
  $admin['password'] = isset($_POST['password']) ? $_POST['password'] : '';
  $admin['confirm_password'] = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

  $result = update_admin($admin);
  if($result === true) {
    $_SESSION['message'] = 'Admin updated.';
    redirect_to(url_for('/staff/admins/view.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $admin = find_admin_by_id($id);
}

?>

<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php include(SHARED_PATH . '/staff_sidebar.php'); ?>

<div class="page-holder w-100 d-flex flex-wrap">
<div class="container-fluid px-xl-5">
  <section class="py-5">
    <div class="row">
      <!-- Basic Form-->
      <div class="col-lg-6 mb-5">
        <div class="card">
          <div class="card-header">
            <h3 class="h6 text-uppercase mb-0">Create Admin</h3>
          </div>
          <div class="card-body">
            <?php echo display_errors($errors); ?>
            <form class="form-horizontal" action="<?php echo url_for('/staff/admins/create.php')?>" method="POST">
              <div><a href="<?php echo url_for('/staff/admins/index.php');?>">&laquo; Back to Admins</a></div>&nbsp;
              <div class="form-group row">
                <label class="col-md-3 form-control-label">First Name</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="text" placeholder="First name" class="form-control form-control-success" name="first_name" value="<?php echo h($admin['first_name']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Last Name</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="text" placeholder="Last name" class="form-control form-control-success" name="last_name" value="<?php echo h($admin['last_name']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Email</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="email" placeholder="Email" class="form-control form-control-success" name="email" value="<?php echo h($admin['email']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">User Name</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="text" placeholder="username" class="form-control form-control-success" name="username" value="<?php echo h($admin['email']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Password</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="password" placeholder="password" class="form-control form-control-success" name="password" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Confirm Password</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="password" placeholder="password" class="form-control form-control-success" name="confirm_password" value="">
                </div>
              </div>
              <div class="form-group row">       
                <div class="col-md-9 ml-auto">
                  <input type="submit" value="Create Admin" class="btn btn-primary">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>  

<?php include(SHARED_PATH . '/staff_footer.php'); ?>