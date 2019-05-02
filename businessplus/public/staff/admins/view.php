<?php

require_once('../../../private/initialize.php');

/*require_login();*/

$id = isset($_GET['id']) ? $_GET['id'] : '1';
$admin = find_admin_by_id($id);

?>

<?php $page_title = 'View Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php include(SHARED_PATH . '/staff_sidebar.php'); ?>

<div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
          <section class="py-5">
            <div class="row">
              <!-- Basic Form-->
              <div class="col-lg-10">
                <div class="card mb-5 mb-lg-0">         
                  <div class="card-header">
                    <h2 class="h6 mb-0 text-uppercase">Category : View</h2>
                  </div>
                  <div class="card-body">
                    <div><a class="back-link" href="<?php echo url_for('/staff/admins/index.php');?>">&laquo; Back to Admins</a></div>&nbsp;
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>First Name</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5><?php echo $admin['first_name']; ?></h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Last Name</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?= $admin['last_name']; ?></h5>
                        </div>
                        </div>    
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Email</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$admin['email']; ?></h5>
                        </div>
                        </div>    
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Username</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$admin['username']; ?></h5>
                        </div>
                        </div>    
                      </div>
                    </div>

                   </div>
                </div>
              </div>
            </div>
          </section>
        </div>  
<?php include(SHARED_PATH . '/staff_footer.php'); ?>
