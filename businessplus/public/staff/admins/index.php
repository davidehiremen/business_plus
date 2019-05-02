<?php require_once('../../../private/initialize.php'); ?>
<?php
$admin_set = find_all_admins();
?>

<?php $page_title = 'All Admins'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php include(SHARED_PATH . '/staff_sidebar.php'); ?>

<div class="page-holder w-100 d-flex flex-wrap">
  <div class="container-fluid px-xl-5">
    <section class="py-5">
      <div class="row">
        <!-- Basic Form-->
        <div class="col-lg-auto">
          <div class="card mb-5 mb-lg-0">         
            <div class="card-header">
              <h2 class="h6 mb-0 text-uppercase">Admin</h2>
              <div class="float-right"><a href="<?= url_for('/staff/admins/create.php') ?>" class="btn-primary btn-sm" style="text-decoration: none;">Add New</a></div>
            </div>
            <div class="card-body"> 
                        
              <table class="table table-striped table-responsive card-text">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First</th>
                    <th>Last</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
                  <tr>
                    <td><?php echo h($admin['id']); ?></td>
                    <td><?php echo h($admin['first_name']); ?></td>
                    <td><?php echo h($admin['last_name']); ?></td>
                    <td><?php echo h($admin['email']); ?></td>
                    <td><?php echo h($admin['username']); ?></td>
                    <td><a class="action" href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['id']))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['id']))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php mysqli_free_result($admin_set);?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>  

<?php include(SHARED_PATH . '/staff_footer.php'); ?>