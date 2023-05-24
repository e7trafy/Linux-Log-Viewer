<?php

use App\Auth;

require_once 'vendor/autoload.php';
session_start();

if (!Auth::isAuthenticated()) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1;
        let totalPages = 1;

        function updateButtons() {
            $('#first-button').prop('disabled', currentPage === 1);
            $('#prev-button').prop('disabled', currentPage === 1);
            $('#next-button').prop('disabled', currentPage === totalPages);
            $('#last-button').prop('disabled', currentPage === totalPages);
        }

        function loadLines(page) {
            const filePath = $('#file-path').val();
            currentPage = page;

            $.ajax({
                type: 'POST',
                url: 'load_lines.php',
                dataType: 'json',
                data: {
                    page: page,
                    file_path: filePath
                },
                success: function(response) {
                    totalPages = response.total_pages;
                    $('#content').html(response.content);
                    updateButtons();
                }
            });
        }

        $(document).ready(function() {
            $('#load-button').on('click', function() {
                loadLines(1);
            });

            $('#first-button').on('click', function() {
                loadLines(1);
            });

            $('#prev-button').on('click', function() {
                if (currentPage > 1) {
                    loadLines(currentPage - 1);
                }
            });

            $('#next-button').on('click', function() {
                if (currentPage < totalPages) {
                    loadLines(currentPage + 1);
                }
            });

            $('#last-button').on('click', function() {
                loadLines(totalPages);
            });
        });
    </script>
</head>
<body>
<nav>
    <a href="logout.php">Logout</a>
    </nav>
    <h1>File Reader</h1>
    <form>
        <label for="file-path">File Path:</label>
        <input type="text" id="file-path" name="file-path" required>
        <button type="button" id="load-button">Load</button>
    </form>
    <table id="content"></table>
    <div>
        <button type="button" id="first-button" disabled>First</button>
        <button type="button" id="prev-button" disabled>Previous</button>
        <button type="button" id="next-button" disabled>Next</button>
        <button type="button" id="last-button" disabled>Last</button>
    </div>
</body>
</html>