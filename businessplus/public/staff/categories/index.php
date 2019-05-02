<?php require_once('../../../private/initialize.php');?>

<?php 
$category_set = find_all_category();

?>

<?php $page_title = 'All Categories'; ?>
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
              <h2 class="h6 mb-0 text-uppercase">Category</h2>
              <div class="float-right"><a href="<?= url_for('/staff/categories/create.php') ?>" class="btn-primary btn-sm" style="text-decoration: none;">Add New</a></div>
            </div>
            <div class="card-body"> 
                        
              <table class="table table-striped table-responsive card-text">
               <thead>
                  <tr>
                    <th>id</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Total Post</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($category = mysqli_fetch_assoc($category_set)) {?>
                  <?php $post_count = count_posts_by_cat_id($category['id']); ?>
                  <tr>
                    <td><?= h($category['id']);?></td>
                    <td><?= h($category['name']);?></td>
                    <td><?= h($category['visible'])== 1 ? 'published' : 'drafted';?></td>
                    <td><?= $post_count; ?></td>
                    <td><a class="btn btn-outline-primary btn-sm" href="<?= url_for('/staff/categories/view.php?id=' .h(u($category['id']))); ?>">view</a></td>
                    <td><a class="btn btn-primary btn-sm" href="<?= url_for('/staff/categories/edit.php?id=' .h(u($category['id']))); ?>">edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="<?= url_for('/staff/categories/delete.php?id=' .h(u($category['id']))); ?>">delete</a></td>
                    <?php } ?>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>  
<?php include(SHARED_PATH . '/staff_footer.php'); ?>