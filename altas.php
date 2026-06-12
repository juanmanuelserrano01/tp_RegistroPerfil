<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $banco_emisor = $_POST['banco_emisor'];
    $usuario = $_POST['usuario'];
    $passwordA = $_POST['passwordA'];
    $passwordB = $_POST['passwordB'];

    if ($passwordA !== $passwordB) {
        die("Error: las contraseñas ingresadas no coinciden. Volver a ingresar");
    }

    $password_final = $passwordA;

    $sql = "INSERT INTO usuarios (nombre, apellido, tipo_doc, documento, fecha_nacimiento, email, banco_emisor, usuario, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("sssssssss", $nombre, $apellido, $tipo_doc, $documento, $fecha_nacimiento, $email, $banco_emisor, $usuario, $password_final);

        if ($stmt->execute()) {
            echo "<h2>¡Usuario registrado con éxito!</h2>";
            echo "<p>Ya podés iniciar sesión desde <a href='ingreso.html'>aquí</a>.</p>";
        } else {
            echo "<h2>Error al registrar el usuario</h2>";
            echo "<p>Es posible que el documento, email o usuario ya se encuentren registrados.</p>";
            echo "<p>Detalle del error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: registro.html");
    exit();
}

?>