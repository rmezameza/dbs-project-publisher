<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Autor:in erstellen</title>
    </head>

    <body>
        <div class="container">
            <h1>Autor:in erstellen</h1>
            <!-- Form for creating a book. Title and box for checking novelty status of a book are required fields -->
            <form method="post"
                  action="index.php?site=autor-absenden&op=neuer-autor"
                  class="mb-4">

                <!-- Author forename -->
                <div class="mb-3">
                    <label for="add_author_forename" class="col-form-label">Vorname:</label>
                    <input type="text"
                           class="form-control"
                           id="add_author_forename"
                           name="forename"
                           maxlength="120"
                           required>
                </div>

                <!-- Author surname -->
                <div class="mb-3">
                    <label for="add_author_surname" class="col-form-label">Nachname:</label>
                    <input type="text"
                           class="form-control"
                           id="add_author_surname"
                           name="surname"
                           maxlength="120">
                </div>

                <!-- Biography -->
                <div class="mb-3">
                    <label for="add_author_bio" class="col-form-label">Biographie:</label>
                    <textarea class="form-control"
                              id="add_author_bio"
                              name="biography"
                              style="height: 100px"></textarea>
                </div>

                <!-- Submit and Return Button -->
                <button type="submit" class="btn btn-primary" title="Autor:in hinzufügen">Autor:in hinzufügen</button>
            </form>
        </div>
    </body>
</html>