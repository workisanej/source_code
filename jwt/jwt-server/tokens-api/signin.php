<?php
include_once './config/database.php';
require "../vendor/autoload.php";
//dont forget to add header configurations for CORS
use \Firebase\JWT\JWT;

$email_address = '';
$password = '';

$dbService = new DB_Connection();
$connection = $dbService->db_connect();

$api_data = json_decode(file_get_contents("php://input"));

$user_email = $api_data->email_address;
$password = $api_data->password;

$table = 'Users';

$sql = "SELECT user_id,first_name, last_name,`password` FROM " . $table . " WHERE email_address =:email  LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(':email', $email_address);
$stmt->execute();
$numOfRows = $stmt->rowCount();

if( $numOfRows > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id    = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $pass       = $row['password'];

    if(password_verify($password, $pass))
    {
        $secret_key = "MillerJumaWilliam";
        $issuer_claim = "localhost"; 
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // time issued 
        $notbefore_claim = $issuedat_claim + 10; 
        $expire_claim = $issuedat_claim + 60; 

        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "firstName" => $first_name,
                "lastName" => $last_name,
                "userEmail" => $email_address
        ));

        $jwtValue = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "success",
                "token" => $jwtValue,
                "email_address" => $email_address,
                "expiry" => $expire_claim
            ));
    }
    else{
        echo json_encode(array("success" => "false"));
    }
}
?>
