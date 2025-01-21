<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Erreur de Permission</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .error-container h1 {
            font-size: 3rem;
            color: #dc3545;
        }
        .error-container p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        .error-container a {
            margin-top: 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .error-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1>Accès Refusé</h1>
    <p>vous n'avez pas les permissions nécessaires pour exécuter cette action.</p>
    {{--  <a href="/">Retour à l'accueil</a>  --}}
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
