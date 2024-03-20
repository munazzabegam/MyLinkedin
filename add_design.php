<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include './includes/db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designName = $_POST["design_name"];

    
    $targetDir = "uploads/";
    $targetFile =  basename($_FILES["design_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    
    if ($_FILES["design_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        
        if (move_uploaded_file($_FILES["design_image"]["tmp_name"],"../uploads/". $targetFile)) {
            
            $imagePath = $targetFile;

            $sql = "INSERT INTO mehendi_designs (design_name, image_path) VALUES ('$designName', '$imagePath')";
            if ($conn->query($sql) === TRUE) {
                echo "New design added successfully.";
                header("Location: ./assets/designs.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Mehendi Design</title>
    <style>

        h1 {
            text-align: center;

        }
        .add-design {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40vh;
        }
        
        .add-design form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
        
        label {
            display: block;
            margin-bottom: 12px;
            color: #333;
            font-weight: 600;
            font-size: 18px;

        }
        
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        button {
            background-color: #2b0505;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;

        }

        button:hover {
            background-color: #f4fcac;
            color: #2b0505;
            font-weight: 600;
        }



    </style>
</head>
<body>
    <h1>Add Mehendi Design</h1>
    <div class="add-design">
    <form action="" method="post" enctype="multipart/form-data">
        <label for="design_name">Design Name:</label>
        <input type="text" id="design_name" name="design_name" required>
        <label for="design_image">Design Image:</label>
        <input type="file" id="design_image" name="design_image" accept="image/*" required>
        <button type="submit">Add Design</button>
    </form>
    </div>
</body>
</html>
