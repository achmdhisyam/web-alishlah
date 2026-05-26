<?php
$targetDir = FCPATH . "assets/upload/image"; // kalau CodeIgniter
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['file']['name'])) {
    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        $fileUrl = base_url("assets/upload/image" . $fileName);
        echo json_encode(['location' => $fileUrl]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Upload failed']);
    }
}
