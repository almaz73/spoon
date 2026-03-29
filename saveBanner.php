<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if a file was uploaded
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    // Get the original file name and create a safe path
    $originalName = basename($_FILES['photo']['name']);
    $filename = 'banner/' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName); // Sanitize filename
    
    // Check if the file is an image
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'error' => 'Недопустимый тип файла']);
        exit;
    }
    
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $filename)) {
        // Return success response with filename
        echo json_encode([
            'success' => true,
            'filename' => basename($filename)
        ]);
    } else {
        // Return error response
        echo json_encode(['success' => false, 'error' => 'Ошибка при сохранении файла']);
    }
} else {
    // Return error response for no file or upload error
    $error = $_FILES['photo']['error'] ?? 'Нет данных для сохранения';
    echo json_encode(['success' => false, 'error' => 'Нет загруженного файла или ошибка загрузки: ' . $error]);
}
?>
