<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../src/vendor/autoload.php';
$app = new \Slim\App;

$app->post('/postNames', function (Request $request, Response $response, array $args) {

    $data = json_decode($request->getBody());

    $fname = $data->fname;
    $lname = $data->lname;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_lily";

    //Database

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO api_names (fname, lname)VALUES ('" . $fname . "','" . $lname . "')";
        $conn->exec($sql);
        //for debugging use only 
        /* $response->getBody()->write(json_encode(array("status" => "success", "data" => null)));*/

        $response = "success";
    } catch (PDOException $e) {

        /*  $response->getBody()->write(json_encode(array("status" => "error", "message" => $e->getMessage())));
        for debugging use only*/
        $response = "failed";
    }
    $conn = null;
    echo $response;
});
$app->post('/getNames', function (Request $request, Response $response, array $args) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_lily";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM api_names";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, array(
                "id" => $row["id"],
                "fname" => $row["fname"],
                "lname" => $row["lname"]
            ));
        }
        $data_body = array("status" => "success", "data" => $data);
        $response->getBody()->write(json_encode($data_body));
    } else {
        $response->getBody()->write(array("status" => "success", "data" => null));
    }
    $conn->close();
});


$app->post('/updateNames', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $id = $data->id;
    $fname = $data->fname;
    $lname = $data->lname;
    //Database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_lily";

    try {
        $conn = new

            PDO("mysql:host=$servername;dbname=$database", $username, $password);

        // set the PDO error mode to exception
        $conn->setAttribute(
            PDO::ATTR_ERRMODE,

            PDO::ERRMODE_EXCEPTION
        );

        $sql = "UPDATE api_names set fname='" . $fname . "', lname='" . $lname . "' where id='" . $id . "'";

        // use exec() because no results are returned
        $conn->exec($sql);
        // $response->getBody()->write(json_encode(array("status" => "success", "data" => null)));
        $response="success";
    } catch (PDOException $e) {
        $response="failed";
        // $response->getBody()->write(json_encode(array("status" => "error", "message" => $e->getMessage())));
    }
    $conn = null;
    echo $response;
});


$app->post('/deleteNames', function (Request $request, Response $response, array $args) {
    $data = json_decode($request->getBody());
    $id = $data->id;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_lily";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "DELETE FROM api_names where id='" . $id . "'";
    if ($conn->query($sql) === TRUE) {
        $response="success";
        // $response->getBody()->write(json_encode(array("status" => "success", "data" => null)));
    } else {
        $response = "failed";
    }
    $conn->close();

    echo $response;
});

$app->post('/searchNames', function (Request $request, Response $response, array
$args) {

    $data = json_decode($request->getBody());
    $id = $data->id;
    //Database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "api_lily";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM api_names where id='" . $id . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            array_push($data, array(
                "id" => $row["id"], "fname" => $row["fname"], "lname" => $row["lname"]
            ));
        }
        $data_body = array("status" => "success", "data" => $data);
        $response->getBody()->write(json_encode($data_body));
    } else {
        $response->getBody()->write(array("status" => "success", "data" => null));
    }
    $conn->close();

    return $response;
});



$app->run();


//Endpoints goes here