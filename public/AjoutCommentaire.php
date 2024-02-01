<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un Commentaire</title>
</head>
<body>
    <?php $id = $_GET["id"] ?>
    <form action="/actions/ajoutCommentaire.php?id=<?= $id ?>" method="post" class="add-product-form">
            <fieldset>
                <legend>Ajouter un Commentaire</legend>

                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire"></textarea><br>

                <label for="notation">Notation</label>
                <input type="number" id="notation" name="notation" required><br>

                <button type="submit">Ajouter le commentaire</button>
            </fieldset>
    </form>
</body>
</html>