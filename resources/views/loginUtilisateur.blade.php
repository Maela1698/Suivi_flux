<!-- filepath: /d:/Stage/ERP-LOI/resources/views/loginUtilisateur.blade.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à l'ERP</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .login-container {
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            width: 400px;
            animation: fadeIn 1s ease-in-out, slideIn 1s ease-in-out;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
            animation: bounceIn 1s ease-in-out;
        }

        .textile-gif {
            width: 100%;
            margin-bottom: 20px;
            border-radius: 15px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
            }
            to {
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            animation: float 3s ease-in-out infinite;
        }

        .shape-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            left: -50px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -100px;
            right: -100px;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .form-control {
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            transform: scale(1.05);
        }

        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
        }

        .toggle-password svg {
            width: 100%;
            height: 100%;
            transition: all 0.3s ease-in-out;
        }

        .toggle-password.open .eye-open {
            display: none;
        }

        .toggle-password.open .eye-closed {
            display: block;
        }

        .eye-closed {
            display: none;
        }
        .btn-custom {
            background: linear-gradient(-10deg, #71b7e6, #9b59b6);
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

    </style>
</head>

<body>

    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="login-container">
            <div class="loi">
            <center>
                <img src="./images/NEW LOGO.png" alt="Entreprise Logo" class="logo">
            </center>

            <img src="./images/fond_logo.gif" alt="Textile Industry" class="textile-gif">
            </div>
            <div class="erp">
            <h3 class="mb-4 text-center">Connexion à l'ERP</h3>

            <form action="{{ route('loginUtilisateur') }}" method="POST" autocomplete="off">
                @csrf
                <div class="mb-3 position-relative">
                    <input type="text" id="username" name="pseudo" class="form-control" placeholder="Matricule" required>
                </div>

                <div class="mb-4 position-relative">
                    <input type="password" id="password" name="mdp" class="form-control" placeholder="Mot de passe" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.97 10.97 0 0 1 12 20c-5.52 0-10-4.48-10-10 0-2.39.84-4.58 2.24-6.32M1 1l22 22"></path>
                            <path d="M9.88 9.88A3 3 0 0 0 12 15c1.66 0 3-1.34 3-3 0-.66-.21-1.27-.56-1.76"></path>
                        </svg>
                    </span>
                </div>

                <button type="submit" class="btn btn-block btn-custom">Se connecter</button>
            </form>
        </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type');
            const togglePasswordIcon = document.querySelector('.toggle-password');

            if (passwordFieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                togglePasswordIcon.classList.add('open');
            } else {
                passwordField.setAttribute('type', 'password');
                togglePasswordIcon.classList.remove('open');
            }
        }
    </script>
</body>

</html>
