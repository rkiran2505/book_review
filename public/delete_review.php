<?php
include('../config/db.php');
session_start();

if (isset($_SESSION['user_id'])) {
    if (isset($_POST['review_id']) && is_numeric($_POST['review_id'])) {
        $review_id = $_POST['review_id'];

        $sql_check = "SELECT user_id FROM reviews WHERE id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("i", $review_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $review = $result_check->fetch_assoc();

            if ($review['user_id'] == $_SESSION['user_id']) {
                $sql_delete = "DELETE FROM reviews WHERE id = ?";
                $stmt_delete = $conn->prepare($sql_delete);
                $stmt_delete->bind_param("i", $review_id);
                if ($stmt_delete->execute()) {
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "not_authorized";
            }
        } else {
            echo "review_not_found";
        }
    } else {
        echo "invalid_request";
    }
}
?>
