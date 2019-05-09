<?php
    header('Content-type: application/json');
    header('Accept: application/json');
    require_once __DIR__ . '/dataLayer.php';

    $action = $_POST["action"];

    switch($action)
    {
        case "PRODUCTS":
            getProducts();
            break;
        case "PRODUCTSD":
            getDescriptions();
            break;
    }

    function getProducts() {
        $response = subGetProducts();
        if ($response["MESSAGE"] == "SUCCESS") {

            $directory = __DIR__ . "/../images/products";

            $images = glob($directory . "/*.jpeg");
            $ret = array();
            $idx = 0;

            foreach($images as $image) {
                $ret[]["image"] = base64_encode(file_get_contents($image));
            }

            $js = json_encode($ret);
            echo $js;
        }
        else {
            subGetErrorByCode($response["MESSAGE"]);
        }
    }

    function getDescriptions() {
        $response = subGetDescriptions();
        if ($response["MESSAGE"] == "SUCCESS") {

            echo json_encode($response["response"]);
        }
        else {
            subGetErrorByCode($response["MESSAGE"]);
        }
    }

    function subGetErrorByCode($errorCode)
    {
        switch($errorCode)
        {
            case "500" : 
                header("HTTP/1.1 500 Bad connection, portal down");
                die("The server is down, we couln't stablish a connection.");
                break;
            case "409" :
                header("HTTP/1.1 409 The email is already taken.");
                die("The username is already taken.");
                break;
            case "406" : 
                header("HTTP/1.1 406 User not found.");
                die("Wrong credentials provided");
                break; 
            case "505" :
                header("HTTP/1.1 505 There has been an error.");
                die("There has been an error.");
                break;
        }
    }
     
 ?>