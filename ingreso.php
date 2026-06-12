<?php

include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tipo_doc = $_POST['tipo_doc'];
    $documento = $_POST['documento'];
    $usuario = $_POST['usuario'];
    $password_ingresada = $_POST['password'];

    $sql = "SELECT id, nombre, apellido, password FROM usuarios WHERE tipo_doc = ? AND documento = ? AND usuario = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("sss", $tipo_doc, $documento, $usuario);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {

            $usuario_db = $resultado->fetch_assoc();

            if ($password_ingresada === $usuario_db['password']) {

                echo "<h2>¡Bienvenido/a, " . $usuario_db['nombre'] . " " . $usuario_db['apellido'] . "!</h2>";
                echo "<p>Has ingresado correctamente al sistema Mis Tarjetas.</p>";

            } else {
                echo "<h2>Error de ingreso</h2>";
                echo "<p>La contraseña introducida es incorrecta.</p>";
                echo "<p><a href='ingreso.html'>Volver a intentar</a></p>";
            }

        } else {

            echo "<h2>Error de ingreso</h2>";
            echo "<p>Los datos ingresados no corresponden a ningún usuario registrado.</p>";
            echo "<p><a href='ingreso.html'>Volver a intentar</a></p>";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
} else {

    header("Location: ingreso.html");
    exit();
}
?>