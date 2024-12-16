
<?php 
include('../connection.php'); 
$userId = $_COOKIE['id'];
if(!$userId){
  header('Location: ../pages/login.html');
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Dashboard | Cuisine</title>
  </head>
  <body>
    <aside>
      <div>
        <img src="../assests/logo.webp" alt="company logo Dashboard" width="80px" height="80px">
        <h2>Dashboard</h2>
      </div>
      <div>
        <a href="#">My Dishes</a>
        <a href="#">Publish Dish</a>
        <a href="#">Orders</a>
      </div>
    </aside>
    <section class="my-dishes">

      <?php 
      if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['action'] == "READ"){
        $query = "SELECT * FROM dish WHERE userId = '$userId'";
        $result = $conn->query($query);
        echo "<h2>My Dishes<h2>";
        while($row = $result->fetch_assoc()){ 
        echo "
            <div class='dish-card'>
                <div>
                  <img src='{$row['image']}' alt='product dish picture' width='100px' >
                </div>
                <div class='text-part'>
                  <h2>{$row['title']}</h2>
                  <p>{$row['descripiton']}</p>
                  <div>
                    <form action='dashboard.php?action=EDIT' method='GET'>
                      <input hidden value='{$row['id']}' name='id' >
                      <button type='submit' name='edit'>Edit</button>
                    </form>
                    <form>
                      <input hidden value='{$row['id']}' name='id' >
                      <button type='submit' name='delete'>Delete</button>
                    </form>
                  </div>
                </div>
            </div>
        ";         
        }
  
        if(isset($_POST['delete'])){
          $id = $_POST['id'];
          $query = "DELETE FROM dish WHERE  id = $id";
          if(!$conn->query($query)){
            die("DELTEION FAILED");
          }
          header("Location: dashboard.php?action=READ");
        }
      }
      ?>


      <?php

        if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['action'] == "EDIT"){
          $id = $_GET['id'];
          $query = "SELECT * FROM dish WHERE id = $id";
          $result = $conn->query($query);
          $row = $result->fetch_assoc();
          if($result->num_rows > 0){
            echo "
            <h2>Edit Dish</h2>
            <form action='dashboard.php?action=READ' class='edit-form' method='post'>

              <div class='img-input'>
                <label for='imgUpload'>
                  <img id='img-dish' src='{$row['image']}' alt='upload iconS' height='180px' width='180px'>
                </label>
                <input type='file' id='imgUpload' name='imgUpload'>
              </div>
              <div>
                <input type='text' name='title' placeholder='Title of Dish' value='{$row['title']}'>
                <input type='text' name='description' placeholder='Description of Dish' value='{$row['description']}'>
                <input type='number' name='price' placeholder='Price of Dish' value='{$row['price']}'>
                <button name='edit' type='submit' >Submit</button>
              </div>
            </form>
            ";
          }    
        }
        if( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit'])){
          $title = $_POST['title'];
          $description = $_POST['description'];
          $price = $_POST['price'];

          $targetDir = 'uploads/';
          $imageName = basename($_FILES['imgUpload']['name']);
          $extension = pathinfo($imageName, PATHINFO_DEFAULT);
          $targetFile = $targetDir . $userId . "_" . uniqid() . $extension;

          if(!oldlink($row['image'])){
            die("Image delete failed");
          }

          if(!move_uploaded_file($_FILES['imgUpload']['tmp_name'], $targetFile))
          {
            die("Uploading photo Failed");
          }



          $query = "UPDATE dish SET image = $targetFile , title = '$title', description = '$description' , price = $price";

          if(!$conn->query($query)){
            die("UPDATION OF RECORD FAILED");
          }
          header("dashboard.php?action=READ");

        }
      
      ?>

      <?php 
      
        if($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['action'] == "CREATE"){
          echo "
            <h2>Publish Dish</h2>
            <form action='#' class='edit-form' method='post'>

              <div class='img-input'>
                <label for='imgUpload'>
                  <img id='img-dish' src='../assests/upload.png' alt='upload iconS' height='180px' width='180px'>
                </label>
                <input type='file' id='imgUpload' name='imgUpload'>
              </div>
              <div>
                <input type='text' name='title' placeholder='Title of Dish' >
                <input type='text' name='description' placeholder='Description of Dish' >
                <input type='number' name='price' placeholder='Price of Dish' >
                <button name='publish' type='submit' >Submit</button>
              </div>
            </form>
            ";
        }

        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['publish'])){
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
  
            $targetDir = 'uploads/';
            $imageName = basename($_FILES['imgUpload']['name']);
            $extension = pathinfo($imageName, PATHINFO_DEFAULT);
            $targetFile = $targetDir . $userId . "_" . uniqid() . $extension;
  
  
            if(!move_uploaded_file($_FILES['imgUpload']['tmp_name'], $targetFile))
            {
              die("Uploading photo Failed");
            }
  
  
  
            $query = "UPDATE dish SET image = $targetFile , title = '$title', description = '$description' , price = $price";
  
            if(!$conn->query($query)){
              die("UPDATION OF RECORD FAILED");
            }
            header("dashboard.php?action=READ");
  
        
        }
      
      ?>
     
      <?php

          
      
      ?>
      <h2>Orders</h2>
      <table border="1px" >
        <thead>
          <th>
          <tr>
            <td></td>
            <td>Name</td>
            <td>Quantity</td>
            <td>Price</td>
            <td>Status</td>
            <td>
              Placed
            </td>
          </tr>
          </th>
        </thead>
        <tbody>
          <tr>
            <td><img src="../assests/logo.webp" alt="Logo" width="80px" height="80px"></td>
            <td>Logo</td>
            <td>3</td>
            <td>300$</td>
            <td ><span class="pending">pending...</span></td>
            <td><button>Completed</button></td>
          </tr>
        </tbody>
      </table>
    </section>
  </body>
</html>
