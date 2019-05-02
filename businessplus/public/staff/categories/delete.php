<?php require_once('../../../private/initialize.php'); ?>


<?php
if (!isset($_GET['id'])) {
  redirect_to(url_for('/staff/categories/index.php'));
}

$id = $_GET['id'];

if (is_post_request()) {
  $result = delete_category($id);
  redirect_to(url_for('/staff/categories/index.php'));
}else{
  $category = find_category_by_id($id); 
}
?>
<?php $page_title = 'Delete category'; ?> 
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
            <h3 class="h6 text-uppercase mb-0">Delete category</h3>
          </div>
          <div class="card-body">
            <?php echo display_errors($errors); ?>
            <h1>Delete Subject</h1>
            <p>Are you sure you want to delete this subject?</p>
            <p class="item"><?php echo h($category['name']); ?></p>

            <form action="<?php echo url_for('/staff/categories/delete.php?id=' . h(u($category['id']))); ?>" method="post">
	            <div class="col-md-9 ml-auto">
                  <input type="submit" value="Delete Category" class="btn btn-primary">
                </div>
        	</form>
            
          </div>
        </div>
      </div>
    </div>
  </section>
</div>  
<div class="card-body">
            

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
