<?php

/*-----categories---------*/

function find_all_category($options=[]){
	global $db;

	$visible = isset($options['visible']) ? $options['visible'] : false;

	$sql = "SELECT * FROM category ";
	if($visible){
		$sql .= "WHERE visible = true ";
	}
	$sql .= "ORDER BY id ASC";

	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function find_category_by_id($id, $options=[]){
	global $db;

	$visible = isset($options['visible']) ? $options['visible'] : false;

	$sql = "SELECT * FROM category ";
	$sql .= "WHERE id='" . db_escape($db, $id) . "' ";
	if($visible){
		$sql .= "AND visible = true ";
	}

	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$category = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $category;
}

function validate_category($category){
	global $db;

	$errors= [];

	if(is_blank($category['name'])){
		$errors[] = 'Name Cannot be blank';
	}elseif(!has_length($category['name'], ['min' => 2, 'max' <= 255])){
		$errors[] = 'Name must be between 2 to 255 characters';
	}

	$visible_str = (string)$category['visible'];
	if (!has_inclusion_of($visible_str, ['0', '1'])) {
		$errors[] = 'Visible must be false or true';
	}

	return $errors;
}

function insert_category($category){
	global $db;
	$errors = validate_category($category);
    if (!empty($errors)) {
    	return $errors;
    } 
	$sql = "INSERT INTO category ";
	$sql .= "(name, visible) ";
	$sql .= "VALUES (";
	$sql .= "'" . db_escape($db, $category['name']) . "',";
	$sql .= "'" . db_escape($db, $category['visible']) . "'";
	$sql .= ")";
	$result = mysqli_query($db, $sql);
	if ($result) {
		return true;
	}else{
		echo mysqli_error($db);
		db_disconnect($db);
		exit;
	}
}

function update_category($category) {
    global $db;

    $errors = validate_category($category);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE category SET ";
    $sql .= "name='" . db_escape($db, $category['name']) . "', ";
    $sql .= "visible='" . db_escape($db, $category['visible']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $category['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }


  function delete_category($id){
    global $db;

    $sql = "DELETE FROM category ";
    $sql .= "WHERE id='" . db_escape($db, $id)."' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }

  //POSTS

function find_current_post($post){
  global $db;

    $per_post = 3;
  for($i=0; $i < $per_post; $i++) {
  $sql = "SELECT * FROM posts ";
  $sql .= "ORDER BY id DESC";
}

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;

} 

function find_all_posts() {
    global $db;

    $sql = "SELECT * FROM posts ";
    $sql .= "ORDER BY cat_id ASC, position ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

function find_posts_by_id($id, $options=[]){
  global $db;

  $visible = isset($options['visible']) ? $options['visible'] : false;

  $sql = "SELECT * FROM posts ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  if ($visible) {
    $sql .= "AND visible= true";
  }
  
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $post = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $post;
}


function validate_post($post){
  $errors = [];
   
   // category_id
    if(is_blank($post['cat_id'])) {
      $errors[] = "Category cannot be blank.";
    }

  //name
  if (is_blank($post['title'])){
    $errors[] = "Title Cannot Be Blank";
  }elseif(!has_length($post['title'], ['min' => 2, 'max' <= 255])){
    $errors[] = "Title mut be greater than 255";
  }

  $current_id = isset($post['id']) ? $post['id'] : '0';
  if (!has_unique_post_title($post['title'], $current_id)) {
    $errors[] = "Post Title Already Exist in this category";
  }

  //position
  $position_int = (int)$post['position'];
  if ($position_int <= 0) {
    $errors[] = "Position Must Be Greater than 0";
}

  //visible
  $visible_str = (string)$post['visible'];
  if (!has_inclusion_of($visible_str, ["0", "1"])) {
    $errors[]= "Visible must be Either True or False";
  }

  // content
  if(is_blank($post['content'])) {
  	$errors[] = "Content cannot be blank.";
  }

  return $errors;
}

function insert_post($post){
  global $db;

  $errors = validate_post($post);

  if (!empty($errors)) {
    return $errors;
  }
 shift_post_position(0, $post['position'], $post['cat_id']);

  $sql = "INSERT INTO posts ";
  $sql .= "(cat_id, title, position, visible, image, content) ";
  $sql .= "VALUES( ";
  $sql .= "'" . db_escape($db, $post['cat_id']) . "',";
  $sql .= "'" . db_escape($db, $post['title']) . "',";
   $sql .= "'" . db_escape($db, $post['position']) . "',";
  $sql .= "'" . db_escape($db, $post['visible']) . "',";
  $sql .= "'" . db_escape($db, $file['name']) . "',";
  $sql .= "'" . db_escape($db, $post['content']) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  if ($result) {
    return true;
  }else{
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_post($post){
  global $db;
  $errors = validate_post($posts);

  if (!empty($errors)) {
    return $errors;
  }

  $old_post = find_posts_by_id($post['id']);
  $old_position = $old_post['position'];
  shift_post_position($old_position, $post['position'], $post['cat_id'], $post['id']);

  $sql = "UPDATE posts SET ";
  $sql .="cat_id='" . db_escape($db, $post['cat_id']) . "', ";
  $sql .="title='" . db_escape($db, $post['title']) . "', ";
 /* $sql .="user_id='" . db_escape($db, $post['user_id']) . "', ";
  $sql .="img='" . db_escape($db, $post['image']) . "', ";*/
  $sql .="content='" . db_escape($db, $post['content']) . "', ";
  $sql .="position='" . db_escape($db, $post['position']) . "', ";
  $sql .="visible='" . db_escape($db, $post['visible']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $post['id']) ."' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  if ($result) {
    return true;
  }else{
    echo mysqli_error($db);
    db_disconnect();
    exit;
  }
}

function delete_post($id) {
    global $db;

    $old_post = find_posts_by_id($id);
    $old_position = $old_post['position'];
    shift_post_position($old_position, 0, $old_post['cat_id'], $id);

    $sql = "DELETE FROM posts ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

function find_posts_by_cat_id($category_id, $options=[]) {
  global $db;

  $visible = isset($options['visible']) ? $options['visible'] : false;

  $sql = "SELECT * FROM posts ";
  $sql .= "WHERE cat_id='" . db_escape($db, $category_id) . "' ";
  if($visible) {
    $sql .= "AND visible = true ";
  }
  $sql .= "ORDER BY position ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function count_posts_by_cat_id($category_id, $options=[]){
  global $db;

  $visible = isset($options['visible']) ? $options['visible'] : false;

  $sql = "SELECT COUNT(id) FROM posts ";
  $sql .= "WHERE cat_id='" . db_escape($db, $category_id) . "' ";
  if($visible){
    $sql .= "AND visible = true ";
  }
  $sql .= "ORDER BY position ASC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count;
}

 function shift_post_position($start_pos, $end_pos, $category_id, $current_id=0) {
    global $db;

    if($start_pos == $end_pos) { return; }

    $sql = "UPDATE posts ";
    if($start_pos == 0) {
      // new item, +1 to items greater than $end_pos
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    } elseif($end_pos == 0) {
      // delete item, -1 from items greater than $start_pos
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    } elseif($start_pos < $end_pos) {
      // move later, -1 from items between (including $end_pos)
      $sql .= "SET position = position - 1 ";
      $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
      $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
    } elseif($start_pos > $end_pos) {
      // move earlier, +1 to items between (including $end_pos)
      $sql .= "SET position = position + 1 ";
      $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
      $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
    }
    // Exclude the current_id in the SQL WHERE clause
    $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";
    $sql .= "AND cat_id = '" . db_escape($db, $category_id) . "'";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

/*ADMIN*/
// Find all admins, ordered last_name, first_name
  function find_all_admins() {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }

  function find_admin_by_username($username) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }

  function validate_admin($admin, $options=[]) {

    $password_required = isset($options['password_required']) ? $options['password_required'] : true;

    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
      $errors[] = "email name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($admin['username'], isset($admin['id'] ) ? $admin['id'] : 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } /*elseif (!has_length($admin['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      }*/ elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      }/* elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }*/

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }

  function insert_admin($admin) {
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function update_admin($admin) {
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if($password_sent) {
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_admin($admin) {
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

?>
