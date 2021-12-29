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

                    <h1 class="h1"><?php echo $book['TITEL']; ?></h1>

                    <?php
                        if($authorArray) {
                            $count = 0;

                            echo "<h2 class='h2'>";

                            foreach ($authorArray as $author) :
                                if ($count > 0) {
                                    echo ", ";
                                }
                                echo $author['AU_VORNAME'] . " " . $author['AU_NACHNAME'];

                                ++$count;
                            endforeach;

                            echo "</h2>";
                        }
                    ?>

                    <div class="row mt-5">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col">
                                    <img class="card-img" src="img/book_covers/<?php echo $book['COVER']; ?>" alt="Buchcover">
                                </div>
                            </div>
                            <div class="row">
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
                                <div class="col">
                                    <p>
                                        <?php echo $book['ISBN']; ?><br />
                                        <?php echo $book['SEITEN_ANZ']; ?><br />
                                        <?php echo $book['PREIS']; ?> Euro<br />
                                        <?php echo $book['SEITEN_ANZ']; ?><br />
                                        <?php echo $book['ERSCH_JAHR']; ?><br />
                                        <?php echo "bahoe " . $book['GENRE']; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <p><?php echo $book['KURZ_BESCHR']; ?></p>
                        </div>
                    </div>
            <?php
                endforeach;
            ?>
        </div>
    </body>
</html>