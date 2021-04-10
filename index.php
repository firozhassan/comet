<?php 

	include_once "autoload.php";

	if(isset($_GET['delete_id'])){
		$delete_id = $_GET['delete_id'];
		$photo_name = $_GET['photo'];
		unlink('photos/' . $photo_name);
		delete('users', $delete_id);
		header("location:http://localhost/student-crudv/");
	}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>XYZ Shop</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

	<?php

	/**
	* Is setting Submit button
	*/
	
	if(isset($_POST['product'])){
		
		$product_name = $_POST['product_name'];
		$regular_price = $_POST['regular_price'];
		$selling_price = $_POST['selling_price'];
		$category = $_POST['category'];
		$brand_name = $_POST['brand_name'];
		$tag = $_POST['tag'];
		$description = $_POST['description'];
		



		 /**
		  * Form Validation
		  */
		if(empty($product_name) || empty($regular_price) ){

			$msg = validate('All fields are Required');

		}else if(dataCheck('comet', 'product_name', $product_name)){
			$msg = validate('Product name needed');
		}elseif(dataCheck('comet', 'regular_price', $regular_price)){
			$msg = validate('Input the product price', 'warning');
		}else{

		//Upload Profile Photo
		$data = move($_FILES['photo'], 'photos/');
		//Get Function
		$unique_name = $data['unique_name'];
		$err_msg = $data['err_msg'];

		if(empty($err_msg)){
		//Data insert to MySQL
		create("INSERT INTO comet (product_name, regular_price, selling_price, category, brand_name, tag, description, product_photo) VALUES ('$product_name', '$regular_price', '$selling_price', '$category', '$brand_name', '$tag', '$description', '$unique_name')");
		
		$msg = validate('Data Stable', 'success');
		}else{
			$msg = $err_msg;
		}
		
		}


	}

	
	?>
	
	

	<div class="wrap-table shadow">
		<a class="btn btn-sm btn-primary" data-toggle="modal" href="#add_student_modal">Add New Product</a>
		<a class="btn btn-sm btn-primary" href="shop-3col.php">Shop</a>
		<br>
		<br>
		<br>
		<?php 
			if(isset($msg)){
				echo $msg;
			}

		?>
		<div class="card">
			<div class="card-body">
				<form class="form-inline float-right" actin="" method="POST">
					<div class="form-group mx-sm-3 mb-2">
						<label for="inputPassword2" class="sr-only">Search</label>
						<input name="search" type="search" class="form-control" id="inputPassword2" placeholder="Search">
					</div>
					<button name="searchbtn" type="submit" class="btn btn-primary mb-2">Search</button>
				</form>
				<h2>All Students</h2>
				<table class="table table-striped">
					<thead>

						<tr>
							<th>#</th>
							<th>product name</th>
							<th>Regular Price</th>
							<th>Selling Price</th>
							<th>Category</th>
							<th>Brand name</th>
							<th>Tag</th>
							<th>Photo</th>
							<th>Action</th>
						</tr>		

					</thead>
					<tbody>

					<?php
					
					$i = 1;
					$data = all('comet');

					if(isset($_POST['searchbtn'])){
						$search = $_POST['search'];

						$sql = "SELECT * FROM comet WHERE product_name LIKE '%$search%' OR category LIKE '%$search%' OR regular_price LIKE '%$search%'";
						$data = connect()->query($sql);
					}

					while($product= $data->fetch_object()) :
				
					?>
						<tr>
							<td><?php echo $i;
								$i++
							?>
							</td>
							<td><?php echo $product->product_name ?></td>
							<td><?php echo $product->regular_price ?></td>
							<td><?php echo $product->selling_price ?></td>
							<td><?php echo $product->category ?></td>
							<td><?php echo $product->brand_name ?></td>
							<td><?php echo $product->tag ?></td>

							<td><img src="photos/<?php echo $product->product_photo ?>" alt=""></td>
							<td>
								<a class="btn btn-sm btn-info" href="single-page.php?show_id=<?php echo $product->id ?>">View</a>
								<a class="btn btn-sm btn-warning" href="edit.php?edit_info=<?php echo $product->id ?>">Edit</a>
								<a class="btn btn-sm btn-danger delete-btn" href="?delete_id=<?php echo $product->id ?>&photo=<?php echo $student->photo ?>">Delete</a>
							</td>
						</tr>

						<?php endwhile; ?>
						

					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Student Create Modal -->
	<div id="add_student_modal" class="modal fade">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h3>Add New Product</h3>
				</div>
				<div class="modal-body">
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for="">Product Name</label>
							<input name="product_name" class="form-control" value="<?php old('product_name'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Product Price</label>
							<input name="regular_price" class="form-control" value="<?php old('regular_price'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Selling Price</label>
							<input name="selling_price" class="form-control" value="<?php old('selling_price'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Category</label>
							<input name="category" class="form-control" value="<?php old('category'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Brand Name</label>
							<input name="brand_name" class="form-control" value="<?php old('brand_name'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Tag</label>
							<input name="tag" class="form-control" value="<?php old('tag'); ?>" type="text">
						</div>
						<div class="form-group">
							<label for="exampleFormControlTextarea1">Product Description</label>
							<textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3" value="<?php old('description'); ?>"></textarea>
						</div>
						<div class="form-group">
							<label for="">product Photo</label><br>
							<img id="preview_product_photo" style="max-width:100%;" src="" alt="">
							<br>
							<label for="product_photo"> <img style="cursor:pointer;" width="100px" src="assets/media/img/up.png" alt=""></label>
							<input id="product_photo" name="photo" style="display:none;" class="form-control" type="file">
						</div>
						<div class="form-group">
							<label for=""></label>
							<input name="product" class="btn btn-primary" type="submit" value="Add Product">
						</div>
					</form>
				</div>
				<div class="model-footer"></div>
			</div>
		</div>
	</div>



	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>

	<script>
	
	$('#product_photo').change(function(e){
	
		let file_url =URL.createObjectURL(e.target.files[0]);
		$('#preview_product_photo').attr('src', file_url);
;
	});

	$('.delete-btn').click(function(){

		let conf = confirm('Are You Sure?');

		if(conf == true){
			return true;
		}else{
			return false;
		}
 
	});
	
	</script>
</body>
</html>