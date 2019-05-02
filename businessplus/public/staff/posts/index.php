<?php require_once('../../../private/initialize.php'); ?>
<?php
$post_set = find_all_posts();
?>

<?php $page_title = 'All Posts'; ?>
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
              <h2 class="h6 mb-0 text-uppercase">Post</h2>
              <div class="float-right"><a href="<?= url_for('/staff/posts/create.php') ?>" class="btn-primary btn-sm" style="text-decoration: none;">Add New</a></div>
            </div>
            <div class="card-body"> 
                        
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
    </section>
  </div>  

<?php include(SHARED_PATH . '/staff_footer.php'); ?>