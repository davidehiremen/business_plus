<?php require_once ('../../src/foundationphp/UploadFile.php'); ?>
<?php require_once('../../../private/initialize.php');?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$post = find_posts_by_id($id);
$cat = find_category_by_id($post['cat_id']);
?>

<?php $page_title = 'View Post'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<?php include(SHARED_PATH . '/staff_sidebar.php'); ?>


<div class="page-holder w-100 d-flex flex-wrap">
        <div class="container-fluid px-xl-5">
          <section class="py-5">
            <div class="row">
              <!-- Basic Form-->
              <div class="col-lg-6">
                <div class="card mb-5 mb-lg-0">         
                  <div class="card-header">
                    <h2 class="h6 mb-0 text-uppercase">Category : <?php echo $post['title']; ?></h2>
                  </div>
                  <div class="card-body">
                    <div><a class="back-link" href="<?php echo url_for('/staff/categories/view.php?id=' . h(u($cat['id']))); ?>">&laquo; Back to posts</a></div>&nbsp;

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
                          <h6 class="mb-0 d-flex align-items-center"> <span>Post Title</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5><?php echo $post['title']; ?></h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Post number</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5><?php echo $post['position']; ?></h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Status</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$post['visible'] == '1' ? 'published' : 'drafted'; ?></h5>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Image</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?= $post['filename']; ?></h5>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Created At</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$post['created_at']; ?></h5>
                        </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start align-items-sm-center mb-4 flex-column flex-sm-row">
                      <div class="left d-flex align-items-center">
                        <div class="text">
                          <h6 class="mb-0 d-flex align-items-center"> <span>Content</span></h6>
                          <div class="right ml-5 ml-sm-0 pl-3 pl-sm-0 text-blue">
                          <h5> <?=$post['content']; ?></h5>
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