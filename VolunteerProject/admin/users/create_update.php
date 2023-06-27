<?php
session_start();
if (!isset($_SESSION['user_login'])) {
    header('Location: C:/xampp/htdocs/Internship/VolunteerProject/admin/login.php');
}

include "../functions/connections.php";
include "../functions/functions.php";

$name = $surname = $fatherName = $leader = $email = $phoneNumber = $startTime = $finishTime = $image = $gender = $nameError = $surnameError = $fatherNameError = $leaderError = $emailError = $phoneNumberError = $startTimeError = $finishTimeError = $imageError = $genderError = $success = $error = "";

$inputVars = array(
    "name" => "",
    "surname" => "",
    "fatherName" => "",
    "leader" => "",
    "email" => "",
    "phoneNumber" => "",
    "startTime" => "",
    "finishTime" => "",
    "image" => "",
    "gender" => "",
);
$errorVars = array(
    "nameError" => "",
    "surnameError" => "",
    "fatherNameError" => "",
    "leaderError" => "",
    "emailError" => "",
    "phoneNumberError" => "",
    "startTimeError" => "",
    "finishTimeError" => "",
    "imageError" => "",
    "genderError" => "",
    "error" => "",
    "succes" => "",
);


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = mysqli_prepare($conn, "UPDATE `volunteerinfos` SET `name`=?, `surname`=?, `fatherName`=?, `leader`=?, `email`=?, `phoneNumber`=?, `startTime`=?, `finishTime`=?, `image`=?, `gender`=? WHERE `id`=?");
        CheckInputsAndExecuteSql($query, $conn, true);
    } else {
        $sql = "SELECT * FROM `volunteerinfos` Where `id` = '$id' ";

        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            $inputVars["name"] = $row["name"];
            $inputVars["surname"] = $row["surname"];
            $inputVars["fatherName"] = $row["fatherName"];
            $inputVars["leader"] = $row["leader"];
            $inputVars["email"] = $row["email"];
            $inputVars["phoneNumber"] = $row["phoneNumber"];
            $inputVars["startTime"] = $row["startTime"];
            $inputVars["finishTime"] = !empty($row["finishTime"]) ? $row["finishTime"] : "";
            $inputVars["gender"] = $row["gender"];
            //$inputVars[ "image" ]     = $row[ "imageName" ];
        }
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = "INSERT INTO `volunteerinfos`(`name`, `surname`, `fatherName`, `leader`, `email`, `phoneNumber`, `startTime`, `finishTime`, `image`, `gender`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        CheckInputsAndExecuteSql($query, $conn, false);
    }
}




function CheckInputsAndExecuteSql(string $sql, $connection, bool $hasIdSetted)
{
    global $inputVars;
    global $errorVars;
    $haveError = false;
    foreach ($inputVars as $key => $value) {
        if ($key != "image") {
            if ($_POST["$key"] == "") {
                $errorVars["$key" . "Error"] = preg_replace('/([a-z])([A-Z])/', '$1 $2', ucfirst("$key is reqiured"));
            } else {
                if ($key == "name" || $key == "surname" || $key == "fatherName" || $key == "leader" || $key == "gender") {
                    $inputVars[$key] = clearInput($_POST["$key"]);
                    if (!preg_match('/^[a-zA-ZəƏçÇşŞöÖıİğĞüÜ\s]+$/', $inputVars[$key])) {
                        $errorVars["$key" . "Error"] = "Only letters allowed";
                    }
                } else if ($key == "phoneNumber") {
                    $inputVars[$key] = clearInput($_POST["$key"]);
                } else if ($key == "email") {
                    $inputVars["email"] = $_POST["email"];
                    if (!filter_var($inputVars["email"], FILTER_VALIDATE_EMAIL)) {
                        $errorVars["emailError"] = "Invalid email format";
                    }
                } else if ($key == "startTime" || $key == "finishTime") {
                    $inputVars[$key] = date('Y-m-d', strtotime(clearInput($_POST["$key"])));
                }

            }
        } else {
            $imageLocation = "C:/xampp/htdocs/Internship/VolunteerProject/uploads/" . $_FILES["image"]["name"];

            $fileFormat = strtolower(pathinfo($imageLocation, PATHINFO_EXTENSION));

            if (file_exists($imageLocation)) {
                $errorVars["$key" . "Error"] = "Uploaded file name is alread exist. Try to rename image";
            } else if ($_FILES["image"]["size"] > 500000) {
                $errorVars["$key" . "Error"] = "Your image is large. Try to send under 5mb images";

            } else if ($fileFormat != "jpg" && $fileFormat != "png") {
                $errorVars["$key" . "Error"] = "Only jpg and png formats allowed";
            } else if (move_uploaded_file($_FILES["image"]["tmp_name"], $imageLocation)) {
                $inputVars[$key] = $_FILES["image"]["name"];
            } else {
                $errorVars["$key" . "Error"] = "Could not upload your image";
            }
        }

    }
    foreach ($errorVars as $value) {
        if ($value != "") {
            $haveError = true;
            break;
        }
    }
    if (!$haveError) {
        $stmt = mysqli_prepare($connection, $sql);
        if ($hasIdSetted) {
            mysqli_stmt_bind_param($stmt, "ssssssssssi", $inputVars["name"], $inputVars["surname"], $inputVars["fatherName"], $inputVars["leader"], $inputVars["email"], $inputVars["phoneNumber"], $inputVars["startTime"], $inputVars["finishTime"], $inputVars["imageName"], $inputVars["gender"], $_GET["id"]);
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssssss", $inputVars["name"], $inputVars["surname"], $inputVars["fatherName"], $inputVars["leader"], $inputVars["email"], $inputVars["phoneNumber"], $inputVars["startTime"], $inputVars["finishTime"], $inputVars["image"], $inputVars["gender"]);
        }

        if (mysqli_stmt_execute($stmt)) {
            $errorVars["succes"] = "Successfull Operation";
        } else {
            $errorVars["error"] = "Unsuccesfull Operation";
        }
    }
}

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


        <div>
            <p id="content">İstifadəçi məlumatlarının redaktəsi</p>
            <span class="abb"> Əsas səhifə/ İstifadəçilər</span>
            <div class="container">
                <div class="content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">Ad <span class="error">*
                                        <?php echo $errorVars["nameError"] ?>
                                    </span></span>

                                <input type="text" name="name" value="<?php echo $inputVars["name"] ?>" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Soyad <span class="error">*
                                        <?php echo $errorVars["surnameError"] ?>
                                    </span> </span>

                                <input type="text" name="surname" value="<?php echo $inputVars["surname"] ?>" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Ata adı <span class="error">*
                                        <?php echo $errorVars["fatherNameError"] ?>
                                    </span></span>

                                <input type="text" name="fatherName" value="<?php echo $inputVars["fatherName"] ?>"
                                    required>
                            </div>
                            <div class="input-box">
                                <span class="details">Rəhbər <span class="error">*
                                        <?php echo $errorVars["leaderError"] ?>
                                    </span></span>

                                <input type="text" name="leader" value="<?php echo $inputVars["leader"] ?>" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Email <span class="error">*
                                        <?php echo $errorVars["emailError"] ?>
                                    </span></span>

                                <input type="text" name="email" value="<?php echo $inputVars["email"] ?>" required>
                            </div>
                            <div class="input-box">
                                <span class="details">Telefon nömrəsi <span class="error">*
                                        <?php echo $errorVars["phoneNumberError"] ?>
                                    </span></span>

                                <input type="text" name="phoneNumber" value="<?php echo $inputVars["phoneNumber"] ?>"
                                    required>
                            </div>
                            <div class="input-box">
                                <span class="details">Başlama tarixi <span class="error">*
                                        <?php echo $errorVars["startTimeError"] ?>
                                    </span></span>

                                <input type="date" name="startTime" value="<?php echo $inputVars["startTime"] ?>"
                                    required>
                            </div>
                            <div class="input-box">
                                <span class="details">Bitirmə tarixi <span class="error">*
                                        <?php echo $errorVars["finishTimeError"] ?>
                                    </span></span>

                                <input type="date" name="finishTime" value="<?php echo $inputVars["finishTime"] ?>"
                                    required>
                            </div>
                            <div class="input-box">
                                <span class="details">Foto şəkil <span class="error">*
                                        <?php echo $errorVars["imageError"] ?>
                                    </span></span>

                                <input class="file-selector-button" style="border: none !important; height: 30px;"
                                    type="file" name="image" required>
                            </div>
                        </div>
                        <div class="gender-details">
                            <input type="radio" name="gender" value="Kişi" <?php if ($inputVars["gender"] == "Kişi") {
                                echo "checked";
                            } ?> id="dot-1">
                            <input type="radio" name="gender" value="Qadın" <?php if ($inputVars["gender"] == "Qadın") {
                                echo "checked";
                            } ?> id="dot-2">
                            <span class="gender-title">Cinsiyyət <span class="error">*
                                    <?php echo $errorVars["genderError"] ?>
                                </span></span>

                            <div class="category">
                                <label for="dot-1">
                                    <span class="dot one"></span>
                                    <span class="gender">Kişi</span>
                                </label>
                                <label for="dot-2">
                                    <span class="dot two"></span>
                                    <span class="gender">Qadın</span>
                                </label>
                            </div>
                        </div>
                        <span class="succes">
                            <?php echo $errorVars["succes"]; ?>
                        </span>
                        <span class="error">
                            <?php echo $errorVars["error"]; ?>
                        </span>
                        <div class="button">
                            <input type="submit" value="Yadda saxla">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include "C:/xampp/htdocs/Internship/VolunteerProject/admin/includes/footer.php";
        ?>
</body>

</html>