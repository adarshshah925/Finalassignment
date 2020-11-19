  
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
   <div id="container">
    <div class="main-heading"><h2>Update Movie To The Page</h2></div>
    <div class="sub-heading"><h4>Update Movie</h4></div>
     <div class="form-wrap">
      <form action="" role="form" method="post">
        <div class="form-group">
          <label for="name">Name:</label>
            <input type="name" name="movie_name" placeholder="Enter Movie Name">
        </div>
        <div class="form-group">
          <label for="name" class="lead">Director:</label>
            <input type="name" name="director" placeholder="Enter Director Name">
        </div>
            <div class="form-group">
               <label for="name" class="lead">Category:</label>
                <input type="name" name="category" placeholder="Enter Category">
            </div>
        <div class="form-group">
          <label for="about">Description:</label>
            <textarea name="description" placeholder="Enter Description"></textarea>
        </div>
        <div class="form-group">
          <label for="about">Upload Movie Image:</label>
            <input type="file" name="file" value="Upload Image">
        </div>
        <button type="submit" name="update">Update</button> 
      </form>
     </div>

   </div>
</body>
</html>
<?php
function insert_data(){
   global $wpdb;
   $table_name=$wpdb->prefix.'my_movie_list';
   $movie_name=$_POST['movie_name'];
   $director=$_POST['director'];
   $category=$_POST['category'];
   $description=$_POST['description'];
   if(isset($_POST['update'])){
       $wpdb->insert($table_name,
                  array(
                        'movie_name'=>$movie_name,
                        'director'=>$director,
                        'category'=>$category,
                        'description'=>$description,),
                  array(
                         '%s',
                          '%s',
                          '%s',
                          '%s',)
               );
   }
}
   //insert query
?>
