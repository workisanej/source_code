<?php
include_once './config/db.php';
require './vendor/autoload.php';
//dont forget to add header configurations for CORS
use Firebase\JWT\JWT;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Max-Age: 3600');
header(
    'Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With'
);

$email_address = '';
$password = '';

$dbService = new DB_Connection();
$connection = $dbService->db_connect();

$api_data = json_decode(file_get_contents('php://input'));

$user_email = $api_data->email_address;
$password = $api_data->password;

$table = 'users';

// $sql =
//     'SELECT user_id,first_name, last_name,`password` FROM ' .
//     $table .
//     ' WHERE email_address =? LIMIT 0,1';

$pwd = mysqli_real_escape_string($mysqli, trim($request->password));
$email = mysqli_real_escape_string($mysqli, trim($request->username));
$sql = "SELECT * FROM users where emailUsers='$email' AND pwdUsers='$pwd'";

$stmt = $connection->prepare($sql);
$stmt->bindParam(1, $email_address);
$stmt->execute();
$numOfRows = $stmt->rowCount();

if ($numOfRows > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $pass = $row['password'];

    if (password_verify($password, $pass)) {
        $secret_key = 'MillerJumaWilliam';
        $issuer_claim = 'localhost';
        $audience_claim = 'THE_AUDIENCE';
        $issuedat_claim = time(); // time issued
        $notbefore_claim = $issuedat_claim + 10;
        $expire_claim = $issuedat_claim + 60;

        $token = [
            'iss' => $issuer_claim,
            'aud' => $audience_claim,
            'iat' => $issuedat_claim,
            'nbf' => $notbefore_claim,
            'exp' => $expire_claim,
            'data' => [
                'id' => $id,
                'firstName' => $first_name,
                'lastName' => $last_name,
                'userEmail' => $email_address,
            ],
        ];
        http_response_code(200);

        $jwtValue = JWT::encode($token, $secret_key);
        echo json_encode([
            'message' => 'Successful login',
            'token' => $jwtValue,
            'email_address' => $email_address,
            'expiry' => $expire_claim,
        ]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => 'false']);
    }
}
?>
