<?php
$message = "";
$fileInfo = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["myfile"]) && $_FILES["myfile"]["error"] == 0) {
        $file = $_FILES["myfile"];

        $fileName = $file["name"];
        $fileSize = $file["size"];
        $fileType = $file["type"];
        $tempName = $file["tmp_name"];

        $uploadFolder = "uploads/";

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        $filePath = $uploadFolder . basename($fileName);

        if (move_uploaded_file($tempName, $filePath)) {
            $fileInfo = [
                "name" => $fileName,
                "size" => $fileSize,
                "type" => $fileType,
                "path" => $filePath
            ];
        } else {
            $message = "File upload failed.";
        }
    } else {
        $message = "Please select a file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CampusCore - File Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>File Upload</h1>
        <p>CampusCore Student Portal</p>
    </header>

    <main>
        <h2>Upload Your File</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Select File</label>
            <input type="file" name="myfile" required>

            <button type="submit">Upload File</button>
        </form>

        <?php if ($message != "") { ?>
            <p class="error"><?php echo $message; ?></p>
        <?php } ?>

        <?php if ($fileInfo != null) { ?>

        <div class="result">
            <h2>Uploaded File Information</h2>

            <p>
                <strong>File Name:</strong>
                <?php echo htmlspecialchars($fileInfo["name"]); ?>
            </p>

            <p>
                <strong>File Type:</strong>
                <?php echo htmlspecialchars($fileInfo["type"]); ?>
            </p>

            <p>
                <strong>File Size:</strong>
                <?php echo round($fileInfo["size"] / 1024, 2); ?> KB
            </p>

            <p>
                <strong>File Location:</strong>
                <?php echo htmlspecialchars($fileInfo["path"]); ?>
            </p>

            <a href="<?php echo htmlspecialchars($fileInfo["path"]); ?>" target="_blank">
                View Uploaded File
            </a>
        </div>

        <?php } ?>
    </main>

    <footer>
        © 2026 CampusCore Student Portal
    </footer>
</div>

</body>
</html>