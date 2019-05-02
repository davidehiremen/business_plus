<?php require_once('../private/initialize.php');?>

<?php
/*if(!is_ajax_request()) { exit; }*/

$post = isset($_GET['post']) ? (int) $_GET['post'] : 1;
/*$cat = find_category_by_id($id);*/
$all_posts = find_current_post($post);
?>

<?php include(SHARED_PATH . '/public_header.php'); ?>
<?php include(SHARED_PATH . '/public_slide.php'); ?>
<section id="body">
<section>
  <div class="row" id="side-bar">
    <div class="logo col-xs-12 col-sm-2 col-md-2 col-lg-2">
      <div class="trending">
        <h3>Trending this week</h3>
        <hr>
        <img src="<?php echo url_for('assets/uploads/mikel.png'); ?>" width="100%">
        <hr>
        <img src="<?php echo url_for('assets/uploads/mahmoud.jpg'); ?>"  width="100%">
        <hr>
        <img src="<?php echo url_for('assets/uploads/gold-medalist.jpg'); ?>"  width="100%">
      </div>
    </div>

    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
      <h4>Recent Stories</h4>
      <div id="all-posts">

        <?php foreach($all_posts as $all_post) { ?>
        <div class="row">
          <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <img src="<?php echo url_for('assets/uploads/bolt.jpg'); ?>" width="100%">
          </div>
          <div class="text col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <h2><?= $all_post['title'] ?></h2>
            <p><?= $all_post['content'] ?></p>
            <a href="<?= url_for('view_post.php?id=' .h(u($all_post['id']))); ?>" class="btn">Read more</a>
          </div>  
        </div>
        <hr>
        <?php } ?>

      </div>
      <div class="load-button">
        <button id="load-more">Load More</button>
      </div>
      <div id="spinner" style="text-align: center; color: orange;">
      <i class="fa fa-spinner fa-spin" style=" font-size: 32px"></i>
      </div>
    </div>

  </div>
</section>
</section>

		
<?php include(SHARED_PATH . '/public_footer.php'); ?>