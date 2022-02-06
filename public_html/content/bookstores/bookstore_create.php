<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Buchlager erstellen</title>
    </head>

    <body>
        <div class="container">
            <h1>Buchlager erstellen</h1>
            <!-- Form for creating a bookstore. Street and zip code are required fields -->
            <form method="post"
                  action="index.php?site=buchlager-submit&op=neues-buchlager"
                  class="mb-4">

                <!-- Street -->
                <div class="mb-3">
                    <label for="add_street" class="col-form-label">Strasse:</label>
                    <input type="text"
                           class="form-control"
                           id="add_street"
                           name="street"
                           maxlength="120"
                           required>
                </div>

                <!-- Zip code -->
                <div class="mb-3">
                    <label for="add_zip" class="col-form-label">Postleitzahl:</label>
                    <input type="text"
                           class="form-control"
                           id="add_zip"
                           name="zip"
                           maxlength="20"
                           required>
                </div>

                <!-- Place -->
                <div class="mb-3">
                    <label for="add_place" class="col-form-label">Ort (Default: Wien):</label>
                    <input type="text"
                           class="form-control"
                           id="add_place"
                           name="place"
                           maxlength="50">
                </div>

                <!-- Country -->
                <div class="mb-5">
                    <label for="add_country" class="col-form-label">Land (Default: Österreich):</label>
                    <input type="text"
                           class="form-control"
                           id="add_country"
                           name="country"
                           maxlength="80">
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary" title="Buchlager hinzufügen">Buchlager hinzufügen</button>
            </form>
        </div>
    </body>
</html>