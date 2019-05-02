<?php require_once ('../../src/foundationphp/UploadFile.php'); ?>
<?php require_once('../../../private/initialize.php'); ?>


<?php
use foundationphp\UploadFile;

$max = 5000 * 1024;
$result = array();

if (is_post_request()) {
  $post = [];
  $post['cat_id'] = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
  $post['position'] = isset($_POST['position']) ? $_POST['position'] : '';
  $post['title'] = isset($_POST['title']) ? $_POST['title'] : '';
  $post['visible'] = isset($_POST['visible']) ? $_POST['visible'] : '';
  $post['content'] = isset($_POST['content']) ? $_POST['content'] : '';
  $post['upload'] = isset($_POST['upload']) ? $_POST['upload'] : '';

  $destination ='../../../uploaded/';
    try {
      $upload = new UploadFile($destination);
      $upload->setMaxSize($max);
      $upload->allowAllTypes();
      $upload->upload();
      $result = $upload->getMessages();
    } catch (Exception $e) {
      $result[] = $e->getMessage();
    }

  $result = insert_post($post);
  if ($result === true) {
    $new_id = mysqli_insert_id($db);
    redirect_to(url_for('staff/posts/view.php?id=' .$new_id));
  }else{
    $errors = $result;
  }
}else{
  $post = [];
  $post['cat_id'] = isset($_GET['cat_id']) ? $_GET['cat_id'] : '1';
  $post['position'] = count_posts_by_cat_id($post['cat_id'])+ 1;
  $post['title'] = '';
  $post['visible'] = '';
  $post['content'] = '';
  $post['filename'] = '';
}
$post_count = count_posts_by_cat_id($post['cat_id'])+ 1;
  

/*image upload*/
/*use foundationphp\UploadFile;

$max = 50 * 1024;
$result = array();
if (isset($_POST['upload'])) {
  require_once 'src/foundationphp/UploadFile.php';
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
}*/

?>

<?php $page_title = 'Create Post'; ?>
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
            <form class="form-horizontal" action="<?php echo url_for('/staff/posts/create.php')?>" method="POST" enctype="multipart/form-data">
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
                    <input type="text" class="form-control" name="title">
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">positon</label>
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
                      <label for="filename">Select File:</label>
                    <input type="file" name="filename" id="filename" value="">
                  </div>
              </div>
              <div class="line"></div>
              <div class="form-group row">
                <label class="col-md-3 form-control-label">Content</label>
                  <div class="col-md-9 select mb-3">
                    <textarea name="content" id="editor"></textarea>
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
                  <input type="submit" value="Create post" name="upload" class="btn btn-primary">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
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