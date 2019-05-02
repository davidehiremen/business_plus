<?php require_once('../../../private/initialize.php') ?>
<?php

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/categories/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {
  $category=[];
  $category['id'] = $id;
  $category['name'] = isset($_POST['name']) ? $_POST['name'] : '';
  $category['visible'] = isset($_POST['visible']) ? $_POST['visible'] : '';

  $result = insert_category($category);
  if ($result === true) {
    redirect_to(url_for('/staff/categories/view.php?id=' . $id));
  }else{
    $errors = $result;
  }
}else{
  $category=find_category_by_id($id);
}

$category_set = find_all_category();
mysqli_free_result($category_set);

?>



<?php $page_title = 'Edit category'; ?> 
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
            <h3 class="h6 text-uppercase mb-0">Edit category</h3>
          </div>
          <div class="card-body">
            <?php echo display_errors($errors); ?>
            <form class="form-horizontal" action="<?php echo url_for('/staff/categories/create.php')?>" method="POST">
              <div><a href="<?php echo url_for('/staff/categories/index.php');?>">&laquo; Back to categories</a></div>&nbsp;
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Name</label>
                <div class="col-md-9">
                  <input id="inputHorizontalSuccess" type="text" placeholder="category name" class="form-control form-control-success" name="name" value="<?php echo h($category['name']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 form-control-label">Publish</label>
                <div class="col-md-9">
                  <div class="custom-control custom-checkbox">
                    <input  type="hidden" value ="0"  name="visible">
                    <input  type="checkbox" value ="1"  name="visible" <?php if($category['visible'] == 1){echo 'checked';}?> >
                  </div>
                </div>
              </div>
              <div class="form-group row">       
                <div class="col-md-9 ml-auto">
                  <input type="submit" value="Edit Category" class="btn btn-primary">
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