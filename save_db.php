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
    
    // ============================================================
    // 1. HANDLE COVER IMAGE UPLOAD
    // ============================================================
    $cover_file = $_FILES['cover_image']['name'] ?? null;
    $cover_tmp = $_FILES['cover_image']['tmp_name'] ?? null;
    $cover_error = $_FILES['cover_image']['error'] ?? null;
    
    // ============================================================
    // 2. HANDLE AUDIO FILE UPLOAD (OPTIONAL)
    // ============================================================
    $audio_file = $_FILES['audio_file']['name'] ?? null;
    $audio_tmp = $_FILES['audio_file']['tmp_name'] ?? null;
    $audio_error = $_FILES['audio_file']['error'] ?? null;
    
    // If editing (has ID) - Check ownership
    if(isset($id) && !empty($id)) {
        $check_sql = "SELECT user_id, cover_image, audio_file FROM music WHERE id = $id";
        $check_result = mysqli_query($conn, $check_sql);
        $check_row = mysqli_fetch_assoc($check_result);
        
        if($check_row['user_id'] != $user_id) {
            header("Location: index.php?error=You don't own this music");
            exit();
        }
        
        // Keep existing files if not uploading new ones
        $existing_cover = $check_row['cover_image'];
        $existing_audio = $check_row['audio_file'];
    }
    
    // ============================================================
    // 3. PROCESS COVER IMAGE UPLOAD
    // ============================================================
    if(!empty($cover_file) && $cover_error == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($cover_file, PATHINFO_EXTENSION));
        
        if(in_array($ext, $allowed)) {
            $new_cover = time() . "_" . $cover_file;
            move_uploaded_file($cover_tmp, "images/" . $new_cover);
            $cover_file = $new_cover;
        } else {
            header("Location: register.php?error=Invalid image file type. Allowed: JPG, PNG, GIF");
            exit();
        }
    } else {
        // Keep existing cover if editing
        $cover_file = isset($existing_cover) ? $existing_cover : null;
    }
    
    // ============================================================
    // 4. PROCESS AUDIO FILE UPLOAD (OPTIONAL - NULL allowed)
    // ============================================================
    if(!empty($audio_file) && $audio_error == 0) {
        $allowed_audio = ['mp3', 'wav', 'ogg'];
        $audio_ext = strtolower(pathinfo($audio_file, PATHINFO_EXTENSION));
        
        // Check file size (max 10MB)
        if($_FILES['audio_file']['size'] > 10485760) {
            header("Location: register.php?error=Audio file too large. Max 10MB");
            exit();
        }
        
        if(in_array($audio_ext, $allowed_audio)) {
            $new_audio = time() . "_" . $audio_file;
            move_uploaded_file($audio_tmp, "audio/" . $new_audio);
            $audio_file = $new_audio;
        } else {
            header("Location: register.php?error=Invalid audio file type. Allowed: MP3, WAV, OGG");
            exit();
        }
    } else {
        // Keep existing audio if editing, or set to NULL if adding new
        $audio_file = isset($existing_audio) ? $existing_audio : null;
    }
    
    // ============================================================
    // 5. SAVE TO DATABASE
    // ============================================================
    
    // If editing (has ID)
    if(isset($id) && !empty($id)) {
        $sql = "UPDATE music SET 
                title='$title', 
                artist='$artist', 
                genre='$genre', 
                price='$price', 
                description='$description', 
                release_date='$release_date',
                cover_image='$cover_file',
                audio_file='$audio_file'
                WHERE id=$id AND user_id=$user_id";
        
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
        $sql = "INSERT INTO music (user_id, title, artist, genre, price, description, release_date, cover_image, audio_file) 
                VALUES ('$user_id', '$title', '$artist', '$genre', '$price', '$description', '$release_date', '$cover_file', '$audio_file')";
        
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