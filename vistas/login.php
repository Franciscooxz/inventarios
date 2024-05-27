<!DOCTYPE html>
<html>
<head>
    <title>Inventario Chinchilla</title>
    <style>

        .logo-container img {
            max-width: 200px;
        }

		.logo-container {
    position: absolute;
    right: 550px; /* Ajusta este valor según la distancia deseada desde el borde derecho */
    top: 50px; /* Ajusta este valor según la distancia deseada desde el borde superior */
}
    </style>
</head>
<body>
    <div class="main-container">
        <div class="logo-container">
		<img src="./img/logo.png">
        </div>
        <form class="box login" action="" method="POST" autocomplete="off">
            <h5 class="title is-5 has-text-centered is-uppercase">Inventario</h5>
            <div class="field">
                <label class="label">Usuario</label>
                <div class="control">
                    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="field">
                <label class="label">Contraseña</label>
                <div class="control">
                    <input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-danger is-rounded">Iniciar Sesión</button>
            </p>
            <?php
            if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
            }
            ?>
        </form>
    </div>
</body>
</html>