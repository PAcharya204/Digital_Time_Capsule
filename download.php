<?php
// download.php
// Make sure a filename parameter is provided

if (!isset($_GET['ffile']) || empty($_GET['ffile'])) {
    die("No file specified.");
}

$filename = basename($_GET['ffile']); // Sanitize filename to avoid directory traversal
$filepath = __DIR__ . '/uploads/' . $filename;

// Check if the file exists
if (!file_exists($filepath)) {
    die("File not found.");
}

// Set headers to force download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));
var_dump($row['ffile']); // See what filename you get
// Clear output buffer before reading the file
ob_clean();
flush();

// Read the file and output it
readfile($filepath);
exit;
?>
