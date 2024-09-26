<?php
include 'Conexion/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subscription_date = $_POST['subscription_date'];
    $website = $_POST['website'];

    // Validar que los campos no estén vacíos
    if (empty($customer_id) || empty($first_name) || empty($last_name) || empty($subscription_date) || empty($website)) {
        echo "<script>alert('Todos los campos son obligatorios.');</script>";
    } else {
        // Validar el formato de la fecha (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $subscription_date)) {
            echo "<script>alert('El formato de la fecha debe ser YYYY-MM-DD.');</script>";
        } else {
            // Insertar datos en la base de datos
            $stmt = $conexion->prepare("INSERT INTO customers (customer_id, first_name, last_name, subscription_date, website) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Error en la preparación de la consulta: ' . $conexion->error);
            }

            // Vincular los parámetros
            $stmt->bind_param('sssss', $customer_id, $first_name, $last_name, $subscription_date, $website);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<script>alert('Cliente registrado correctamente.');</script>";
            } else {

                // Redirigir a la página de inserción
                header("Location: insert.php");
                exit();
                echo "<script>alert('Error al registrar el cliente: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        }
    }
}
?>
