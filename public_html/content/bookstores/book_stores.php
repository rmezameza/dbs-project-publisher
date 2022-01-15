<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Buchlager</title>
    </head>

    <body>
        <div class="container">
            <?php
                include_once 'func/class/BookstoreHandler.php';

                $bookstoreHandler = new BookstoreHandler();
                $storeArray = $bookstoreHandler->getBookstoreAndCapacity(null);

                $totalCapacity = 0;
                $totalBooks = 0;

                foreach($storeArray as $store) :
                    $totalCapacity += $store['GESAMTKAPAZITAET'];
                    $totalBooks += $store['GESAMTBUECHER'];
                endforeach;

                $actualBooksInPercent = (100 / $totalCapacity) * $totalBooks;
            ?>


            <h1 class="mb-5">Buchlager</h1>
            <a class="btn btn-secondary" href="index.php?site=buchlager-buecheranzahl-bearbeiten" title="Buchlager - Buchanzahl bearbeiten">
                Buchanzahl bearbeiten
            </a>
            <h2 class="mt-5">Gesamtstatus aller Buchlager</h2>
            <p>Momentan gibt es insgesamt <?php echo $totalBooks . " Bücher bei einer Gesamtkapazität für " . $totalCapacity . " Bücher"; ?></p>
            <div class="progress" style="width: 50%;">
                <div class="progress-bar progress-bar-striped"
                     role="progressbar"
                     style="width: <?php echo $actualBooksInPercent; ?>%"
                     aria-valuenow="<?php echo $actualBooksInPercent; ?>"
                     aria-valuemin="0"
                     aria-valuemax="100"></div>
            </div>

            <h2 class="mt-5">
                Liste der Buchlager:
            </h2>
            <?php


                foreach($storeArray as $store) :
                    $actualBooksInPercentOneBookstore = (100 / $store['GESAMTKAPAZITAET']) * $store['GESAMTBUECHER'];
            ?>
                <div class="row">
                    <div class="col">
                        <a class="link-dark"
                            href="index.php?site=buchlager-detail&bookstoreid=<?php echo $store['LAG_ID']; ?>"
                            title="Buchlager verwalten">
                            <?php echo $store['LAG_STRASSE'] . ", " . $store['LAG_PLZ'] . " " . $store['LAG_ORT']; ?>
                        </a>
                    </div>
                    <div class="col">
                        <?php echo $store['GESAMTBUECHER'] . " / " . $store['GESAMTKAPAZITAET'] ?>
                    </div>
                    <div class="col">
                        <div class="progress" style="width: 25%;">
                            <div class="progress-bar progress-bar-striped"
                                 role="progressbar"
                                 style="width: <?php echo $actualBooksInPercentOneBookstore ?>%"
                                 aria-valuenow="<?php echo $actualBooksInPercentOneBookstore; ?>"
                                 aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <hr class="text-decoration-line-through">
            <?php endforeach; ?>
        </div>
    </body>
</html>