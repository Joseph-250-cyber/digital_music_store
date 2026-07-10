<?php
session_start();
include("inc/connection.php");

// Check if user is logged in and is an artist
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'artist') {
    header("Location: index.php?error=Only artists can add music");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $release_date = mysqli_real_escape_string($conn, $_POST['release_date']);
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    
    // Handle file upload
    $file_name = $_FILES['cover_image']['name'] ?? null;
    $file_tmp = $_FILES['cover_image']['tmp_name'] ?? null;
    $file_error = $_FILES['cover_image']['error'] ?? null;
    
    // If editing (has ID) - Check ownership
    if(isset($id) && !empty($id)) {
        $check_sql = "SELECT user_id FROM music WHERE id = $id";
        $check_result = mysqli_query($conn, $check_sql);
        $check_row = mysqli_fetch_assoc($check_result);
        
        if($check_row['user_id'] != $user_id) {
            header("Location: index.php?error=You don't own this music");
            exit();
        }
    }
    
    // Upload image if provided
    if(!empty($file_name) && $file_error == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)) {
            $new_filename = time() . "_" . $file_name;
            move_uploaded_file($file_tmp, "images/" . $new_filename);
            $file_name = $new_filename;
        } else {
            header("Location: register.php?error=Invalid file type. Allowed: JPG, PNG, GIF");
            exit();
        }
    }
    
    // If editing (has ID)
    if(isset($id) && !empty($id)) {
        if(!empty($file_name)) {
            $sql = "UPDATE music SET 
                    title='$title', 
                    artist='$artist', 
                    genre='$genre', 
                    price='$price', 
                    description='$description', 
                    release_date='$release_date',
                    cover_image='$file_name' 
                    WHERE id=$id AND user_id=$user_id";
        } else {
            $sql = "UPDATE music SET 
                    title='$title', 
                    artist='$artist', 
                    genre='$genre', 
                    price='$price', 
                    description='$description', 
                    release_date='$release_date' 
                    WHERE id=$id AND user_id=$user_id";
        }
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?success=Music updated successfully");
            exit();
        } else {
            header("Location: edit.php?id=$id&error=" . mysqli_error($conn));
            exit();
        }
    } 
    // If adding new (no ID)
    else {
        $sql = "INSERT INTO music (user_id, title, artist, genre, price, description, release_date, cover_image) 
                VALUES ('$user_id', '$title', '$artist', '$genre', '$price', '$description', '$release_date', '$file_name')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?success=Music added successfully");
            exit();
        } else {
            header("Location: register.php?error=" . mysqli_error($conn));
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>