<?php
include "functions/connections.php";
session_start();
if (!isset($_SESSION['user_login'])) {
    header('Location: C:/xampp/htdocs/Internship/VolunteerProject/admin/login.php');
}
$tokenDelete = bin2hex(random_bytes(32));
$_SESSION['csrf_token_delete'] = $tokenDelete;

$sql = "SELECT * FROM volunteerinfos";

$result = $conn->query($sql);
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
            <h1>Bütün Könüllülər</h1>
            <br>
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
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $row["id"] ?>
                                </td>
                                <td>
                                    <?php echo $row["name"] ?>
                                </td>
                                <td>
                                    <?php echo $row["surname"] ?>
                                </td>
                                <td>
                                    <?php echo $row["fatherName"] ?>
                                </td>
                                <td>
                                    <?php echo $row["leader"] ?>
                                </td>
                                <td>
                                    <?php echo $row["email"] ?>
                                </td>
                                <td>
                                    <?php echo $row["phoneNumber"] ?>
                                </td>
                                <td>
                                    <?php echo $row["startTime"] ?>
                                </td>
                                <td>
                                    <?php echo $row["finishTime"] ?>
                                </td>
                                <td>
                                    <?php echo $row["image"] ?>
                                </td>
                                <td>
                                    <?php echo $row["gender"] ?>
                                </td>
                                <td><a href="users/update.php?id=<?php echo $row["id"]; ?>">Update</a>
                                </td>
                                <td><a
                                        href="users/delete.php?id=<?php echo $row["id"]; ?>&csrf_token_delete=<?php echo $tokenDelete; ?>">Delete</a>
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