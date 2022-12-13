<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload souborů</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
</body>
<?php


if ($_FILES) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedNazev']['name']);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadSuccess = true;

    if($_FILES['uploadedNazev']['error'] != 0) {
        echo "Chyba serveru při uploadu";
        $uploadSuccess = false;
    }

    elseif (file_exists($targetFile)) {
        echo "Soubor existuje";
        $uploadSuccess = false;
    }

    elseif ($_FILES['uploadedNazev']['size'] > 8000000) {
        echo "Soubor je moc velký";
        $uploadSuccess = false;
    }

    elseif($fileType !== "jpg" && $fileType !== "png" && $fileType !== "svg" && $fileType !== "mp4" && $fileType !== "mp3") {
        echo "soubor má špatný typ";
        $uploadSuccess = false;

    }


    if(!$uploadSuccess) {
        echo "Došlo k chybě upladu";
    } else {
        if(move_uploaded_file($_FILES['uploadedNazev']['tmp_name'], $targetFile)) {
            echo "Soubor " . basename($_FILES['uploadedNazev']['name']) . " byl uložen.";
            ShowMedia($targetFile, $fileType);
        } else {
            echo "došlo k chybě uploadu";
        }
    }


}
function ShowMedia($targetFile, $fileType) {
if($fileType == 'png' || $fileType == 'jpg' || $fileType == 'svg') {
    echo "<div><img src='$targetFile' alt='Uploaded image'></div>";
} elseif ($fileType == 'mp4') {
    echo "<div><video controls>";
    echo "<source src='$targetFile' type='video/mp4'>";
    echo "</video></div>";
}
elseif ($fileType == 'mp3') {
    echo "<div><audio controls><source src='$targetFile' type='audio/mp3'></audio></div>";
}
}
?>

<form method='post' action='' enctype='multipart/form-data'><div class="container">
    <div class="label">Select media to upload:</div>
    <div class="mb-3">
    <label for="formFile" class="form-label"></label>
    <input type="file"  class="form-control form-control-sm" id="formFileSm" name="uploadedNazev" accept="image/*, video/*, audio/*" />
    <input type="submit" value="Nahrát" name="submit" class="btn btn-primary"/>
    </div>
</div></form>
</body>
</html>