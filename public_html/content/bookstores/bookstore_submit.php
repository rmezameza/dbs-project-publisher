<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books</title>
    </head>

    <body>
        <div class="container">
            <?php
                include_once 'func/class/BookstoreHandler.php';
                include_once 'func/inc/sec.inc.php';

                $bookstoreHandler = new BookstoreHandler();

                $amountOfBooks = $bookID = $bookstoreID = $rackID = $rackCapacity = $sumBooksSpeficicRack = $checkDeletion = 0;
                $bookidGenre = $genre = "";

                if($_SERVER['REQUEST_METHOD'] == "POST") {
                    if(isset($_POST['bookstore_id'])) {
                        $bookstoreID = (int)sanitizeInput($_POST['bookstore_id']);
                    }

                    if(isset($_POST['bookid_genre'])) {
                        $bookidGenre = sanitizeInput($_POST['bookid_genre']);
                        $bookidGenre = explode('#', $bookidGenre);
                        $bookID = (int)$bookidGenre[0];
                        $genre = $bookidGenre[1];
                    }

                    if(isset($_POST['bookstore_book_deletion'])) {
                        $checkDeletion = (int)sanitizeInput($_POST['bookstore_book_deletion']);
                    }

                    if(isset($_POST['amount_of_books'])) {
                        $amountOfBooks = (int)sanitizeInput($_POST['amount_of_books']);
                    }
                }

                if($bookstoreHandler->checkGenreExistInBookstore($bookstoreID, $genre) == null) {
                    echo "<h1 class='mb-5'>Achtung!</h1>";
                    echo "<p>Es gibt kein Regal für dieses Genre</p>";

                    echo "<a class='btn btn-secondary' href='index.php?site=buchlager-buecheranzahl-bearbeiten' titel='Zurück'>Zurück</a>";
                    exit;
                }

                $rackID = $bookstoreHandler->getRackID($genre, $bookstoreID);

                if($checkDeletion) {
                    if($bookstoreHandler->deleteBookInRack($bookID, $rackID, $bookstoreID)) {
                        echo "<h1 class='mb-5'>Erfolgreich!</h1>";
                        echo "<p>Das Buch wurde erfolgreich aus dem Buchlager gelöscht.</p>";
                    }
                    else {
                        echo "<h1 class='mb-5'>Fehler!</h1>";
                        echo "<p>Das Buch wurde leider nicht aus dem Buchlager gelöscht.</p>";
                    }
                }
                else {
                    $rackCapacity = $bookstoreHandler->getRackCapacity($rackID, $bookstoreID);
                    $sumBooksSpeficicRack = $bookstoreHandler->getSumBooksForSpecificRack($bookstoreID, $rackID);

                    if($bookstoreHandler->checkIfBookInRack($bookID, $rackID, $bookstoreID) == null) {
                        if($rackCapacity <= ($amountOfBooks + $sumBooksSpeficicRack[0]['SUMME_BUECHER_REGAL'])) {
                            echo "<h1 class='mb-5'>Fehler!</h1>";
                            echo "<p>" .
                                "Da das Buch nicht im Regal gab, wurde versucht es hinzuzufügen.<br>" .
                                "Jedoch würde die gewünschte Buchanzahl von '{$amountOfBooks}' die Kapazität überschreiten.<br>" .
                                "Derzeitiger Stand:  {$sumBooksSpeficicRack[0]['SUMME_BUECHER_REGAL']} / {$rackCapacity} Bücher" .
                                "</p>";
                        }
                        else {
                            if($bookstoreHandler->addBookToRack($bookID, $rackID, $bookstoreID, $amountOfBooks)) {
                                echo "<h1 class='mb-5'>Erfolgreich!</h1>";
                                echo "<p>Das Buch gab es nicht im Regal und wurde automatisch hinzugefügt.</p>";
                            }
                            else {
                                echo "<h1 class='mb-5'>Fehler!</h1>";
                                echo "<p>Das Buch hätte automatisch hinzugefügt werden sollen. Es gab jedoch einen Fehler!</p>";
                            }
                        }

                    }
                    else {
                        if($rackCapacity <= ($amountOfBooks + $sumBooksSpeficicRack[0]['SUMME_BUECHER_REGAL'])) {
            ?>
                            <h1 class="mb-5">Fehler!</h1>
                            <p>Die eingegebene Anzahl von "<?php echo $amountOfBooks ?>" Bücher überschreitet die Regalkapazität.</p>
                            <p>Derzeitiger Stand: <?php echo $sumBooksSpeficicRack[0]['SUMME_BUECHER_REGAL'] . " / " . $rackCapacity; ?> Bücher.</p>
            <?php
                        }
                        else {
                            if($bookstoreHandler->updateAmountOfBooksInRack($bookID, $rackID, $bookstoreID, ($amountOfBooks + $sumBooksSpeficicRack[0]['SUMME_BUECHER_REGAL']))) {
                                echo "<h1 class='mb-5'>Erfolgreich!</h1>";
                                echo "<p>Die Buchanzahl wurde erfolgreich aktualisiert.</p>";
                            }
                            else {
                                echo "<h1 class='mb-5'>Fehler!</h1>";
                                echo "<p>Die Buchanzahl wurde leider nicht aktualisiert.</p>";
                            }
                        }
                    }
                }

            ?>
            <a class="btn btn-secondary" href="index.php?site=buchlager-buecheranzahl-bearbeiten" titel="Zurück">Zurück</a>
    </body>
</html>