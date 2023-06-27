<?php
include "functions/connections.php";
session_start();
if (!isset($_SESSION[ 'user_login' ])) {
  header( 'Location: login.php' );
}
$sql = "SELECT * FROM volunteerinfos";

$result = $conn->query( $sql );

$counter = 0;
?>


<!DOCTYPE html>
<html lang="en">
<?php
include "C:/xampp/htdocs/Internship/VolunteerProject/admin/includes/head.php";
?>

<body>
  <?php
  include "C:/xampp/htdocs/Internship/VolunteerProject/admin/includes/nav.php";
  ?>

  <main>
    <?php
    include "C:/xampp/htdocs/Internship/VolunteerProject/admin/includes/sidebar.php";
    ?>
    <div class="container">
      <div class="fa-1">
        <div class="follower">
          <span class="text">Follower
            <hr>
          </span>
          <p class="numbers">1500</p>

        </div>
        <div class="viewer">
          <span class="text">Viewer
            <hr>
          </span>
          <p class="numbers">1283</p>
        </div>
        <div class="news">
          <span class="text">News
            <hr>
          </span>
          <p class="numbers">1992</p>
        </div>
      </div>
      <!--   
        <div class="inputArea">
          <input class="input" type="text">
        </div> -->

      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Ad</th>
            <th scope="col">Soyad</th>
            <th scope="col">Ata adı</th>
            <th scope="col">Rəhbər</th>
            <th scope="col">Email</th>
            <th scope="col">Telefon</th>
            <th scope="col">Başlama tarixi</th>
            <th scope="col">Bitirmə tarixi</th>
            <th scope="col">Şəkil adı</th>
            <th scope="col">Cinsiyyəti</th>
          </tr>
        </thead>
        <tbody>

          <?php
          if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
              if ($counter <= 15)
                $counter++;
              else
                break;
              ?>
              <tr>
                <td>
                  <?php echo $row[ "id" ] ?>
                </td>
                <td>
                  <?php echo $row[ "name" ] ?>
                </td>
                <td>
                  <?php echo $row[ "surname" ] ?>
                </td>
                <td>
                  <?php echo $row[ "fatherName" ] ?>
                </td>
                <td>
                  <?php echo $row[ "leader" ] ?>
                </td>
                <td>
                  <?php echo $row[ "email" ] ?>
                </td>
                <td>
                  <?php echo $row[ "phoneNumber" ] ?>
                </td>
                <td>
                  <?php echo $row[ "startTime" ] ?>
                </td>
                <td>
                  <?php echo $row[ "finishTime" ] ?>
                </td>
                <td>
                  <?php echo $row[ "image" ] ?>
                </td>
                <td>
                  <?php echo $row[ "gender" ] ?>
                </td>
              </tr>
              <?php
            }
          }
          ?>

        </tbody>
      </table>
    </div>

  </main>
  <!-- <div onclick="toggleTheme('light');" class="darkMode"> -->

  </div>
  <?php
  include "C:/xampp/htdocs/Internship/VolunteerProject/admin/includes/footer.php";
  ?>
</body>

</html>