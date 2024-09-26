<?php
include 'Conexion/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $customer_id = $_POST['customer_id'];

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password) || empty($customer_id)) {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
    } else {
        // Insertar datos en la base de datos
        $stmt = $conexion->prepare("INSERT INTO users (email, password, customer_id) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conexion->error);
        }

        // Vincular los parámetros
        $stmt->bind_param('sss', $email, $password, $customer_id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Usuario registrado correctamente.');</script>";
        } else {
            echo "<script>alert('Error al registrar el usuario: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }
}
?>
