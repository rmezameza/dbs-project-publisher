<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Buch erstellen</title>
    </head>

    <body>
        <div class="container">
            <h1>Buch erstellen</h1>
            <!-- Form for creating a book. Title and box for checking novelty status of a book are required fields -->
            <form method="post"
                  action="index.php?site=buch-absenden&prev=neues-buch"
                  class="mb-4">

                <!-- ISBN Number -->
                <div class="mb-3">
                    <label for="add_isbn" class="col-form-label">ISBN:</label>
                    <input type="number"
                           class="form-control"
                           id="add_isbn"
                           name="isbn"
                           maxlength="13">
                </div>

                <!-- Book title -->
                <div class="mb-3">
                    <label for="add_title" class="col-form-label">Titel:</label>
                    <input type="text"
                           class="form-control"
                           id="add_title"
                           name="title"
                           maxlength="100"
                           required>
                </div>

                <!-- Name of cover image -->
                <div class="mb-3">
                    <label for="add_cover_name" class="col-form-label">Name des Covers (inkl. Dateiformat):</label>
                    <input type="text"
                           class="form-control"
                           id="add_cover_name"
                           name="cover"
                           maxlength="110">
                </div>

                <!-- Number of pages -->
                <div class="mb-3">
                    <label for="add_number_of_pages" class="col-form-label">Seitenanzahl:</label>
                    <input type="number"
                           class="form-control"
                           id="add_number_of_pages"
                           name="nr_of_pages">
                </div>

                <!-- Book price -->
                <div class="mb-3">
                    <label for="add_price" class="col-form-label">Preis:</label>
                    <input type="number"
                           class="form-control"
                           id="add_price"
                           name="price">
                </div>

                <!-- Year of release -->
                <div class="mb-3">
                    <label for="add_release_year" class="col-form-label">Erscheinungsjahr:</label>
                    <input type="number"
                           class="form-control"
                           id="add_release_year"
                           name="release_year">
                </div>

                <!-- Genre -->
                <div class="mb-3">
                    <label for="add_genre" class="col-form-label">Genre:</label>
                    <select class="form-select" aria-label="add_genre" name="genre">
                        <option selected>Bitte auswählen</option>
                        <option value="politics">Politics</option>
                        <option value="literature">Literature</option>
                        <option value="history">History</option>
                        <option value="theory">Theory</option>
                        <option value="comics">Comics</option>
                        <option value="art-books">Art Books</option>
                        <option value="kids">Kids</option>
                    </select>
                </div>

                <!-- Check if it is a novelty book -->
                <div class="mb-3">
                    <p class="pt-2">Neuerscheinung</p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="novelty_status" id="add_novelty_status_yes" checked>
                        <label class="form-check-label" for="add_novelty_status_yes">
                            Ja
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="novelty_status" id="add_novelty_status_no">
                        <label class="form-check-label" for="add_novelty_status_no">
                            Nein
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="add_book_description" class="col-form-label">Buch Beschreibung:</label>
                    <textarea class="form-control"
                              id="add_book_description"
                              name="description"
                              style="height: 100px"></textarea>
                </div>

                <!-- Submit and Return Button -->
                <button type="submit" class="btn btn-primary" title="Buch hinzufügen">Buch hinzufügen</button>
            </form>
        </div>
    </body>
</html>