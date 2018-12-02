<?php
$data = $_POST['data'];

try {
    $conn = new PDO("mysql:host=localhost;dbname=db_ingles",
        'root', 'acessoroot');
    $sql = "INSERT INTO rst VALUES(0, '{$data}')";
    $conn->query($sql);

    echo $sql;
} catch(PDOException $e) {
    echo '{"success": false, "message": ' . $e->getMessage();
}
$conn = null;
