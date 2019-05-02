<?php require_once('../../../private/initialize.php'); ?>


<?php

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/posts/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {
  $post = [];
  $post['id'] = $id;
  $post['cat_id'] = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
  $post['title'] = isset($_POST['title']) ? $_POST['title'] : '';
  $post['position'] = isset($_POST['position']) ? $_POST['position'] : '';
  /*$post['user_id'] = isset($_POST['user_id']) ? $_POST['user_id'] : '';*/
  $post['content'] = isset($_POST['content']) ? $_POST['content'] : '';
  $post['visible'] = isset($_POST['visible']) ? $_POST['visible'] : '';

  $result = update_post($post);
  if($result === true) {
    $_SESSION['message'] = 'The post was updated successfully.';
    redirect_to(url_for('/staff/posts/view.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $post = find_posts_by_id($id);
  $post['position'] = count_posts_by_cat_id($post['cat_id']);

}

$post_count = count_posts_by_cat_id($post['cat_id']);


/*image upload*/
use foundationphp\UploadFile;

$max = 50 * 1024;
$result = array();
if (isset($_POST['image'])) {
  require_once '../../src/foundationphp/UploadFile.php';
  $destination = __DIR__ . '/uploaded/';
    try {
      $upload = new UploadFile($destination);
      $upload->setMaxSize($max);
      $upload->allowAllTypes();
      $upload->upload();
      $result = $upload->getMessages();
    } catch (Exception $e) {
      $result[] = $e->getMessage();
    }
}
?>

<?php $page_title = 'Edit Post'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php include(SHARED_PATH . '/staff_sidebar.php'); ?>
<div class="page-holder w-100 d-flex flex-wrap">
<div class="container-fluid px-xl-5">
  <section class="py-5">
    <div class="row">
      <!-- Basic Form-->
      <div class="col-lg-12 mb-5">
        <div class="card">
          <div class="card-header">
            <h3 class="h6 text-uppercase mb-0">create category</h3>
          </div>
          <div class="card-body">
            <?php echo display_errors($errors); ?>
            <form class="form-horizontal" action="<?php echo url_for('/staff/posts/edit.php?id=' . h(u($id)));?>" method="POST" enctype="multipart/form-data">
              <div><a class="back-link" href="<?php echo url_for('/staff/categories/view.php?id=' . h(u($post['cat_id']))); ?>">&laquo; Back to posts</a></div>&nbsp;
              <!-- category name -->
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Category Name</label>
                  <div class="col-md-9 select mb-3">
                    <select class="form-control" name="cat_id">
                      <?php
                          $category_set = find_all_category();
                          while($category = mysqli_fetch_assoc($category_set)) {
                            echo "<option value=\"" . h($category['id']) . "\"";
                            if($post["cat_id"] == $category['id']) {
                              echo " selected";
                            }
                            echo ">" . h($category['name']) . "</option>";
                          }
                          mysqli_free_result($category_set); 
                        ?>
                    </select>
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Post Title</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" name="title" value="<?php echo h($post['title']); ?>">
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">position</label>
                  <div class="col-md-9 select mb-3">
                    <select name="position" class="form-control">
                      <?php
                        for($i=1; $i <= $post_count; $i++) {
                          echo "<option value=\"{$i}\"";
                          if($post['position'] == $i) {
                            echo " selected";
                          }
                          echo ">{$i}</option>";
                        }
                      ?>
                    </select>
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Image</label>
                  <div class="col-md-9 select mb-3">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max;?>">
                    <input type="file" name="image" id="filename" multiple value="<?php echo h($post['image']); ?>">
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Content</label>
                  <div class="col-md-9 select mb-3">
                    <textarea name="content" id="editor"><?php echo h($post['content']); ?></textarea>
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-sm-3 form-control-label">Publish</label>
                <div class="col-md-9">
                  <div class="custom-control custom-checkbox">
                    <input  type="hidden" value ="0"  name="visible">
                    <input  type="checkbox" value ="1"  name="visible" <?php if($post['visible'] == 1){echo 'checked';}?> >
                  </div>
                </div>
              </div>
              <div class="form-group row">       
                <div class="col-md-9 ml-auto">
                  <input type="submit" value="Edit Post" class="btn btn-primary">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>  

<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>"></script>
  <script>
    ClassicEditor
      .create( document.querySelector( '#editor' ) )
      .then( editor => {
              console.log( editor );
      } )
      .catch( error => {
              console.error( error );
      } );
</script>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>