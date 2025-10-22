<?php
//1️⃣ Tell browser that response will be JSON
header("Content-Type: application/json");

// 2️⃣ Connect to database
$servername = "localhost"; // XAMPP default
$username = "root";
$password = "";            // XAMPP default empty
$dbname = "hackathon_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// If DB connection fails
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed."]));
}

// 3️⃣ Get input from frontend (POST request)
$data = json_decode(file_get_contents("php://input"), true); 
// input JSON ni PHP array ga convert chestundi
$error = trim($data["error"]); // extra spaces remove

// If input is empty
if(empty($error)){
    echo json_encode(["result" => "Please enter an error name."]);
    exit();
}

// 4️⃣ Check database for the error
$sql = "SELECT error_explanation FROM errors WHERE error_name='$error'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc(); // get the explanation
    echo json_encode(["result" => $row["error_explanation"]]);
} else {
    echo json_encode(["result" => "Error not found in database."]);
}

// 5️⃣ Close the database connection
$conn->close();
?>
