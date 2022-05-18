<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .login {
            min-height: 100vh;
        }

        .bg-image {
            background-size: cover;
            background-position: center;
        }

        .login-heading {
            font-weight: 300;
        }

        .btn-login {
            font-size: 0.9rem;
            letter-spacing: 0.05rem;
            padding: 0.75rem 1rem;
        }
    </style>
</head>

<body>
    <?php session_start();
    $dniError = "";

    ?>




    <?php

    if (isset($_POST["entrar"])) {
        $cifrada = hash_hmac('sha512', $_POST["password"], "primeraweb");
        $enlace = mysqli_connect("localhost", "comprobarusuario", "comprobarusuario", "consulta");
        $usuario = 'SELECT dniUsu,usuLogin,usuPassword,usuTipo FROM usuarios WHERE dniUsu="' . $_POST["dni"] . '" AND usuPassword="' . $cifrada . '"';
        $dato = mysqli_query($enlace, $usuario);

        $dni = $_POST["dni"];

        function validar_dni($dni)
        {
            $letra = substr($dni, -1);
            $numeros = substr($dni, 0, -1);
            if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
                return true;
            } else {
                return false;
            }
        }



        $fila = mysqli_fetch_assoc($dato);
        if (isset($fila)) {
            $_SESSION['r'] = $fila['usuTipo'];
            $_SESSION['login'] = $fila["usuLogin"];
            $_SESSION['dniUsu'] = $fila["dniUsu"];
        }




        if (validar_dni($dni) == false) {
            $dniError = "El DNI no es válido";
        } elseif (validar_dni($dni) == true) {
            $dniError = "DNI válido";
            if (mysqli_num_rows($dato) == 0) {
                $dniError = "El DNI no existe en la base de datos";
            } else {
                if ($_SESSION['r'] == "Administrador") {
                    header("Location:administrador/admin.php");
                } else if ($_SESSION['r'] == "Asistente") {
                    header("Location:asistente/asistente.php");
                } else if ($_SESSION['r'] == "Medico") {
                    header("Location:medico/medico.php");
                } else if ($_SESSION['r'] == "Paciente") {
                    header("Location:paciente/paciente.php");
                }
            }
        }
    }
    ?>
    <header class="border-bottom topnavbar bg-success shadow-sm">
    <div class="container">
      <nav class="navbar navbar-expand-sm bg-success navbar-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="imagenes/logo.png" alt="Avatar Logo" style="width:40px;">
            El Santuario
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>

        <div class="collapse navbar-collapse" id="mynavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="actividades.html">Actividades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="instalaciones.html">Instalaciones</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contacto.html">Contacto</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
          </ul>

        </div>
      </nav>
    </div>
  </header>
    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Bienvenido</h3>

                               
                                <form action="#" method="POST">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Introduce DNI" name="dni" required> <span class="error"><?php echo $dniError; ?></span>
                                        <label for="floatingInput">DNI</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="Introduce la contraseña" name="password" required>
                                        <label for="floatingPassword">Password</label>
                                    </div>


                                    <div class="d-grid">
                                        <input type="submit" name="entrar" value="Entrar" class="btn btn-lg btn-success btn-login text-uppercase fw-bold mb-2">

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-white bg-success">
    <div class="container pt-4">
      <section class="mb-4">
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
          </svg></i
        ></a>
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
          </svg></a>
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
          </svg>
        </a>
      </section>
    </div>
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright
    </div>
  </footer>
</body>

</html>