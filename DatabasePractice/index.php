<form action="" method = "Post" >
    <input type="text" name = "volunteerName">
    <input type="submit">
</form>
<?php
include "dbConnnection.php";
$nameErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["volunteerName"])) {
      $nameErr = "Name is required";
    } else {
      $name = test_input($_POST["volunteerName"]);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
      }
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  if(empty($nameErr)){
    echo $name."<br>";
  }
  else{
    echo $nameErr;
  }
$sql = "SELECT * FROM volunteerinfos WHERE name=?"; // SQL with parameters
$stmt = $conn->prepare($sql); 
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if($result->num_rows > 0){
    echo $result->num_rows;
}

?>