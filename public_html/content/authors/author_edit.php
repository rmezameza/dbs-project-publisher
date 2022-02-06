<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Bahoe Book - Buch bearbeiten</title>
    </head>

    <body>
        <div class="container">
            <h1 class="mb-5">Autor:in bearbeiten</h1>
            <?php
                require_once 'func/class/AuthorHandler.php';

                $authorhandler = new AuthorHandler();
                $authorID = isset($_GET['autorid']) ? htmlentities($_GET['autorid']) : null;

                if($authorID == null || !is_numeric($authorID)) {
                    include_once 'error/not_allowed.html';
                    exit;
                }

                $authorArray = $authorhandler->getSpecificAuthor($authorID);

                foreach($authorArray as $author) :
                    ?>
                        <div class="row text-center">

                        <!-- Form for editing a book. It will contain the actual data for overview. -->
                        <form method="post"
                          action="<?php echo "index.php?site=autor-absenden&op=autor-detail" .
                              "&autorid=" . $authorID; ?>"
                          class="mb-4">

                            <!-- Change Forename -->
                            <div class="mb-3">
                                <label for="change_forename" class="col-form-label">Vorname:</label>
                                <input type="text"
                                       class="form-control"
                                       id="change_forename"
                                       name="forename"
                                       maxlength="100"
                                       placeholder="<?php echo $author['AU_VORNAME']; ?>">
                            </div>

                            <!-- Change Surname -->
                            <div class="mb-3">
                                <label for="change_surname" class="col-form-label">Nachname:</label>
                                <input type="text"
                                       class="form-control"
                                       id="change_surname"
                                       name="surname"
                                       maxlength="100"
                                       placeholder="<?php echo $author['AU_NACHNAME']; ?>">
                            </div>

                            <!-- Change biography -->
                            <div class="mb-3">
                                <label for="change_biography" class="col-form-label">Biographie:</label>
                                <textarea class="form-control"
                                          id="change_biography"
                                          name="biography"
                                          placeholder="<?php echo $author['BIO']; ?>"
                                          style="height: 100px;"></textarea>
                            </div>

                            <!-- Submit and Return Button -->
                            <button type="submit" class="btn btn-primary" title="Buch bearbeiten">Autor:in bearbeiten</button>
                            <a class="btn btn-secondary"
                               href="index.php?site=autor-detail&autorid=<?php echo $authorID; ?>"
                               title="Zurück">
                                Zurück
                            </a>
                        </form>
                    </div>
                <?php endforeach; ?>
        </div>
    </body>
</html>