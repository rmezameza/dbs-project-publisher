<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Detail zum Buchlager</title>
    </head>

    <body>
        <div class="container">
            <h1>Buchlager - Detail</h1>
            <?php
                include_once 'func/class/BookstoreHandler.php';

                $bookstoreHandler = new bookstoreHandler();
                $bookstoreID = isset($_GET['bookstoreid']) ? htmlentities($_GET['bookstoreid']) : null;

                if(is_null($bookstoreID)) {
                    include_once 'error/not_allowed.html';
                    exit;
                }

                $bookstoreArray = $bookstoreHandler->getSpecificBookstoreOrAll($bookstoreID);
                $rackArray = $bookstoreHandler->getOneOrMoreRacks($bookstoreID, null);
            ?>
            <h2 class="mb-5"><?php echo $bookstoreArray[0]['LAG_STRASSE'] . ", " . $bookstoreArray[0]['LAG_PLZ'] . " " . $bookstoreArray[0]['LAG_ORT']; ?></h2>

            <div class="row mb-5">
                <div class="col-lg-2">
                    <a class="btn btn-secondary" href="index.php?site=neues-regal&bookstoreid=<?php echo $bookstoreID; ?>" title="Regal hinzufügen">
                        Regal hinzufügen
                    </a>
                </div>
                <div class="col">
                    <a class="btn btn-secondary" href="index.php?site=buchlager-edit&bookstoreid=<?php echo $bookstoreID; ?>" title="Buchlager bearbeiten">
                        Buchlager Bearbeiten
                    </a>
                </div>
            </div>

            <?php
                if(count($rackArray) == 0) {
                    echo "<h3>Das Buchlager hat momentan keine Regale.</h3>";
                    exit;
                }
            ?>


            <?php
                foreach($rackArray as $rack) :
            ?>
                <div class="row">
                    <div class="col">
                        <p>
                            <?php echo "Regal Nr.: " . $rack['REGAL_NR'] . " | Genre: " . $rack['REGAL_NAME']; ?><br>
                            <?php echo "Platz für <strong>" . $rack['REGAL_KAPAZITAET'] . "</strong> Bücher"; ?>
                        </p>
                    </div>
                    <div class="col">
                        <a class="link-dark"
                           onClick="return confirm('Dieses Regal wirklich löschen?')"
                           href="index.php?site=buchlager-submit&op=regal-loeschen&bookstoreid=<?php echo "{$bookstoreID}&regalnr={$rack['REGAL_NR']}"; ?>">
                            Löschen
                        </a>
                    </div>
                </div>
                <hr class="text-decoration-line-through">
            <?php endforeach; ?>
        </div>
    </body>
</html>