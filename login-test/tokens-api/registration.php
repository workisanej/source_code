<?php
include_once './config/db.php';
include_once './header.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$full_name= '';
$email_address = '';
$password1 = '';
$connection = null;

$db = new DB_Configuration();
$connection = $db->db_connect();

$api_data = json_decode(file_get_contents("php://input"));

$full_name = $api_data->full_name;
$email_address = $api_data->email;
$password = $api_data->password;

$query = "INSERT INTO " users . "
                SET full_name = :fname,
                    email = :emailAdress,
                    password = :pwd";

$stmt = $conn->prepare($query);

$stmt->bindParam(':fname',$full_name)
$stmt->bindParam(':email', $email_address);
$stmt->bindParam(':password', $password1);
$stmt->execute();
?>