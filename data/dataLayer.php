<?php

    function getDatabaseConnection()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "jose";

	   $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error)
        {
            return null;
        }
        else
        {
            return $conn;
        }
    }

    function subGetProducts()
    {
        $connection = getDatabaseConnection();
        
        if ($connection != null) {
            $sql = "SELECT
                        *
                    FROM
                        Products;";
            
            $result = $connection->query($sql);
            
            if ($result) {
                $response = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $response[] = array("id" => $row["Id"],
                                           "description" => $row["Description"]);
                    }
                }
                
                $connection->close();
                return array("response" => $response,
                            "MESSAGE" => "SUCCESS");
            }
            else {
                $connection->close();
                return array("MESSAGE" => "406");
            }
        }
        else {
            return array("MESSAGE" => "500");
        }
    }

    function subGetDescriptions() {
        $connection = getDatabaseConnection();
        
        if ($connection != null) {
            $sql = "SELECT
                        *
                    FROM
                        Products;";
            
            $result = $connection->query($sql);
            
            if ($result) {
                $response = array();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $response[]["description"] = mb_convert_encoding($row["Description"], 'UTF-8', 'UTF-8');
                    }
                }
                
                $connection->close();
                return array("response" => $response,
                            "MESSAGE" => "SUCCESS");
            }
            else {
                $connection->close();
                return array("MESSAGE" => "406");
            }
        }
        else {
            return array("MESSAGE" => "500");
        }
    }

?>