<?php
class ConnectDB
{
    function connection()
    {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'mediconnect';

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }        
        return $conn;
    }
}
