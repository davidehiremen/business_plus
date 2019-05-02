<?php require_once('../../../private/initialize.php');?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$cat = find_category_by_id($id);
$post_set = find_posts_by_cat_id($id);
?>

<?php $page_title = 'View Category'; ?>
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
                    <div><a class="back-link" href="<?php echo url_for('/staff/categories/index.php');?>">&laquo; Back to categories</a></div>&nbsp;
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Category Name</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5><?php echo $cat['name']; ?></h5>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Status</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$cat['visible'] == '1' ? 'published' : 'drafted'; ?></h5>
                        </div>
                        </div>
                        
                      </div>
                    </div>

              <div class="header">
              <h2 class="h6 mb-0 text-uppercase">Post</h2><a href="<?php echo url_for('/staff/posts/create.php?cat_id=' . h(u($cat['id']))); ?>" class="btn-primary btn-sm" style="text-decoration: none;">Add New</a>
            </div>&nbsp;
            <div class="body">
                        
              <table class="table table-striped table-responsive card-text">
               <thead>
                  <tr>
                    <th>id</th>
                    <th>Post Number</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>content</th>
                    <th>Created at</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($post = mysqli_fetch_assoc($post_set)) {?>
                  <?php $category = find_category_by_id($post['cat_id']); ?>
                  <tr>
                    <td><?= h($post['id']);?></td>
                    <td><?= h($post['position']);?></td>
                    <td><?= h($post['title']);?></td>
                    <td><?= h($post['visible'])== 1 ? 'published' : 'drafted';?></td>
                    <td><?= h(substrwords($post['content'], 10));?></td>
                    <td><?= h($post['created_at']);?></td>
                    <td><a class="btn btn-outline-primary btn-sm" href="<?= url_for('/staff/posts/view.php?id=' .h(u($post['id']))); ?>">view</a></td>
                    <td><a class="btn btn-primary btn-sm" href="<?= url_for('/staff/posts/edit.php?id=' .h(u($post['id']))); ?>">edit</a></td>
                    <td><a class="btn btn-danger btn-sm" href="<?= url_for('/staff/posts/delete.php?id=' .h(u($post['id']))); ?>">delete</a></td>
                    <?php } ?>
                  </tr>
                </tbody>
              </table>
              <?php mysqli_free_result($post_set);?>
            </div>

                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>  
<?php include(SHARED_PATH . '/staff_footer.php'); ?>