<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Bahoe Books - Buchdetail</title>
    </head>
    <body>
        <div class="container">
            <?php
                require_once 'func/class/BookHandler.php';
                require_once 'func/inc/book.inc.php';

                $bookHandler = new BookHandler();
                $buchID = isset($_GET['buchid']) ? htmlentities($_GET['buchid']) : null;

                if($buchID == null || !is_numeric($buchID)) {
                    include_once 'error/not_allowed.html';
                    exit;
                }

                $authorArray = $bookHandler->getAuthorsForBook($buchID);
                $bookArray = $bookHandler->getSpecificBook($buchID);

                foreach($bookArray as $book) :
            ?>
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <a class="link-dark"
                               onClick="return confirm('Das Buch >><?php echo $book['TITEL']; ?><< wirklich löschen?')"
                               href="index.php?site=buch-absenden&op=buch-loeschen&type=<?php echo $book['GENRE']; ?>&buchid=<?php echo $book['BUCH_ID']; ?>">
                                Delete
                            </a>
                        </div>
                        <div class="p-2">
                            <p>
                                <a class="link-dark"
                                   href="index.php?site=buchedit&prev=buchdetail&buchid=<?php echo $book['BUCH_ID']; ?>"
                                   title="Buch bearbeiten">
                                    Edit
                                </a>
                            </p>
                        </div>
                    </div>
                    <h1><?php echo $book['TITEL']; ?></h1>

                    <?php
                        if($authorArray) {
                            $count = 0;

                            echo "<h2 class=''><small class='text-muted'>";

                            foreach ($authorArray as $author) :
                                if ($count > 0) {
                                    echo ", ";
                                }

                                echo "<a href='index.php?site=autor-detail&autorid={$author['AUTOR_ID']}'
                                                             class='link-dark'
                                                             title='{$author['AU_VORNAME']} {$author['AU_NACHNAME']}'>";
                                echo $author['AU_VORNAME'] . " " . $author['AU_NACHNAME'];
                                echo "</a>";

                                ++$count;
                            endforeach;

                            echo "</small></h2>";
                        }
                    ?>
                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <div class="row mb-4">
                                <div class="col">
                                    <img class="img-fluid" src="img/book_covers/<?php
                                                                                    if($book['COVER'] == null) {
                                                                                        echo "book_cover_na.jpg";
                                                                                    }
                                                                                    else {
                                                                                        echo $book['COVER'];
                                                                                    }
                                                                                 ?>"
                                         alt="Buchcover" width="80%">
                                </div>
                            </div>
                            <div class="row">
                                <!-- TODO: Fix the problem with mobile view
                                <div class="col-lg-5">
                                    <p>
                                        ISBN:<br />
                                        Seiten:<br />
                                        Preis:<br />
                                        Seitenanzahl:<br />
                                        Erscheinungsjahr:<br/>
                                        Genre:
                                    </p>
                                </div>
                                -->
                                <div class="col">
                                    <p>
                                        <?php
                                            if($book['ISBN']) {
                                                echo $book['ISBN'] . "<br>";
                                            }
                                            else {
                                                echo "Keine ISBN Nummer zugewiesen. <br>";
                                            }

                                            if($book['SEITEN_ANZ']) {
                                                echo $book['SEITEN_ANZ'] . " Seiten <br>";
                                            }
                                            else {
                                                echo "Seitenanzahl nicht bekannt. <br>";
                                            }

                                            if($book['Preis']) {
                                                echo $book['PREIS'] . " Euro <br>";
                                            }
                                            else {
                                                echo "Kein Preis vergeben. <br>";
                                            }

                                            if($book['ERSCH_JAHR']) {
                                                echo $book['ERSCH_JAHR'] . " (Erscheinungsdatum) <br>";
                                            }
                                            else {
                                                echo "Erscheinungsdatum unbekannt. <br>";
                                            }

                                            echo "Genre ist >>bahoe " . $book['GENRE'] . "<<";
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <p><?php
                                    if($book['KURZ_BESCHR']) {
                                        echo $book['KURZ_BESCHR'];
                                    }
                                    else {
                                        echo "Momentan ist keine Buchbeschreibung vorhanden.";
                                    }
                               ?>
                            </p>
                        </div>
                    </div>
            <?php
                endforeach;
            ?>
        </div>
    </body>
</html>