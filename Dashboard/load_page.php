<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec Animation de Chargement</title>
    <style>
        /* Style pour le conteneur de chargement */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Au-dessus de tout le reste */
        }

        /* Animation d'un spinner circulaire */
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #ccc;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Animation du texte de chargement */
        .loading-text {
            font-family: Arial, sans-serif;
            font-size: 18px;
            font-weight: bold;
            color: #555;
            animation: blink 1.5s linear infinite;
        }

        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        /* Contenu principal masqué initialement */
        #content {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Conteneur de chargement -->
    <div id="loader">
        <div class="spinner"></div>
        <div class="loading-text"><?php echo ($usrActif->lang == 'FR' || $usrActif->lang == '' ? "Chargement des données en cours..." : "Data loading ...." )?></div>
    </div>

    <script>
        // Masquer le logo de chargement après 1 seconde
        window.addEventListener('load', function () {
            setTimeout(function () {
                document.getElementById('loader').style.display = 'none';
            }, 100); // Délai de 1 seconde
        });
    </script>
</body>
</html>
