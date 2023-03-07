<?php
function pingUser() {
    session_start();

    include "../../config.php";

    $user_id = $_SESSION['id'];

    $sql = "UPDATE users SET last_activity = CURRENT_TIMESTAMP() WHERE id = $user_id";

    if(mysqli_query($link, $sql)) {
        // echo "Record updated successfully";
    } else {
        // echo "Error updating record: " . mysqli_error($link);
    }

    $sql = "SELECT username FROM users WHERE last_activity > DATE_SUB(NOW(), INTERVAL 1 MINUTE)";
    $result = mysqli_query($link, $sql);
    $usernames = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $usernames[] = $row["username"];
        }
        return $usernames;
    } else {
        return "No users online.";
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