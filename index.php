<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <h2>Calculer la distance entre 2 villes</h2>

        <p>Choisissez deux villes:</p>

        <!--Make sure the form has the autocomplete function switched off:-->
        <form autocomplete="off">
            <div class="autocomplete" style="width:300px;">
                <input id="ville1" type="text" name="ville1" placeholder="Ville">
            </div>
            <div class="autocomplete" style="width:300px;">
                <input id="ville2" type="text" name="ville2" placeholder="Ville">
            </div>
            <input type="submit" id="submit" name="submit">
        </form>
        <div id="distance" style="height: 1rem;"></div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ville 1</th>
                    <th>Ville 2</th>
                    <th>Distance</th>
                    <th>Heure et date de la requête</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <script type="module" src="./js/script.js"></script>
</body>

</html>