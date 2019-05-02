<?php require_once('../private/initialize.php');?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$post = find_posts_by_id($id);
$cat = find_category_by_id($post['cat_id']);
?>

<?php $post_title = $post['title'];  ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>
<section id="body">
<section>
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" id="post">
			<h1 class="post-title"><?= $post['title']; ?></h1>
			<div class="row">
				<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
					<h4 class="time"><?=$post['created_at'];?></h4>
				</div>
				<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
					<h4 class="share"><a href=""><i class="fa fa-facebook"></i></a>
					 <a href=""><i class="fa fa-instagram"></i></a> 
					 <a href=""><i class="fa fa-twitter"></i></a> 
					</h4>
				</div>
			</div>
			<hr>
			<img src="images/gold-medalist.jpg" width="100%">
			<div class="post-body">
				<?= $post['content'] ?>
			</div>
			<hr>
			<h3>Related Topics</h3>
				<div class="row tags">
					<a href="">Common wealth</a>
					<a href="">Olympics</a>
					<a href="">Doping</a>
					<a href="">Weight lifting</a>
				</div>
		</div>
		<div class="logo col-xs-12 col-sm-2 col-md-2 col-lg-2" id="side-bar">
			<div class="trending">
				<h3>Trending this week</h3>
				<hr>
				<img src="images/mikel.png" width="100%">
				<hr>
				<img src="images/mahmoud.jpg"  width="100%">
				<hr>
				<img src="images/gold-medalist.jpg"  width="100%">
			</div>
		</div>
	</div>
</section>
</section>
<?php include(SHARED_PATH . '/public_footer.php'); ?>