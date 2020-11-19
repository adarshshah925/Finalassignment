<?php
 global $wpdb;
 $table_name=$wpdb->prefix.'my_movie_list';
 $result=$wpdb->get_results("SELECT * FROM $table_name");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
   <div id="container">
	<input type="text" name="" id="my_input" placeholder="Search By Director Name" onkeyup="searchFun()">
	<input type="text" name="" id="my_category" placeholder="Search By Category" onkeyup="searchFun2()">
	<div class="table">
		<table cellspacing="0" id="content-table">
			<thead>
				<tr>
				<th>ID</th>
				<th>Movie Name</th>
				<th>Director</th>
				<th>Category</th>
				<th>Image</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody class="border">
				<?php foreach($result as $row){
                      $id=$row->id;
                      $movie_name=$row->movie_name;
                      $director=$row->director;
                      $category=$row->category;
                      $created_at=$row->created_at;
					?>
				<tr>
					<td><?php echo $id; ?></td>
					<td><?php echo $movie_name; ?></td>
					<td><?php echo $director; ?></td>
					<td><?php echo $category; ?></td>
					<td></td>
					<td><?php echo $created_at; ?></td>
					<td>
						<a class="btn" href="admin.php?page=movie-edit">Edit</a>
						<a class="btn" style="background: red">Delete</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</body>
</html>