<?php
function pingUser() {
    session_start();

    include "../../config.php";

    $user_id = $_SESSION['id'];

    $sql = "UPDATE users SET last_activity = CURRENT_TIMESTAMP() WHERE id = $user_id";

    if(mysqli_query($link, $sql)) {
        return "Record updated successfully";
    } else {
        return "Error updating record: " . mysqli_error($link);
    }

    mysqli_close($link);
}

$request_body = file_get_contents('php://input');
$data = json_decode($request_body);
if (isset($data->functionName)) {
    $result = call_user_func($data->functionName);
    echo json_encode($result);
} else {
    echo json_encode(array("error" => "Missing 'functionName' parameter"));
}
?>