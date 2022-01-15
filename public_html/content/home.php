<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Bahoe Books - Home</title>
    </head>
    <body>
        <h1 class="h1">Dashboard</h1>
            <div class="container mt-5 border border-2 border-dark rounded rounded-3">
                <?php
                    include_once 'func/class/BookHandler.php';
                    include_once 'func/class/BookstoreHandler.php';

                    $bookHandler = new BookHandler();
                    $bookstoreHandler = new BookstoreHandler();

                    $books = $bookHandler->getAllBooks(null, "buch_id DESC");
                    $arraySize = count($books);

                    $storeArray = $bookstoreHandler->getBookstoreAndCapacity( null);

                    $totalCapacity = 0;
                    $totalBooks = 0;
                    $totalBooksInPercent = 0.0;

                    foreach($storeArray as $store) :
                        $totalCapacity += $store['GESAMTKAPAZITAET'];
                        $totalBooks += $store['GESAMTBUECHER'];
                    endforeach;

                    $totalBooksInPercent = (100 / $totalCapacity) * $totalBooks;

                    $count = 0;

                   if($arraySize > 0) {
                ?>
                    <div class="row mb-5">
                        <div class="row mb-3">
                            <div class="col">
                                <h2 class="h2 mt-3">Die drei neuesten Bücher:</h2>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col">
                                <div class="row">
                                        <div class="col">
                                            <img src="img/book_covers/<?php echo $books[$arraySize - 1]['COVER']; ?>"
                                                 class="img-thumbnail"
                                                 width="30%"
                                                 alt="Coverbild vom Buch '<?php echo $books[$arraySize - 1]['TITEL']; ?>'">
                                        </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <p><?php echo $books[$arraySize - 1]['TITEL']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php if($arraySize > 1) { ?>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <img src="img/book_covers/<?php echo $books[$arraySize - 2]['COVER']; ?>"
                                             class="img-thumbnail"
                                             width="30%"
                                             alt="Coverbild vom Buch '<?php echo $books[$arraySize - 2]['TITEL']; ?>'">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <p><?php echo $books[$arraySize - 2]['TITEL']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                                if($arraySize > 2) {
                            ?>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <img src="img/book_covers/<?php
                                                                    if($books[$arraySize - 3]['COVER'] == null) {
                                                                        echo "book_cover_na.jpg";
                                                                    }
                                                                    else {
                                                                        echo $books[$arraySize - 3]['COVER'];
                                                                    }?>"
                                             class="img-thumbnail"
                                             width="30%"
                                             alt="Coverbild vom Buch '<?php echo $books[$arraySize - 3]['TITEL']; ?>'">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <p><?php echo $books[$arraySize - 3]['TITEL']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                   }
                   else {
                       echo "<h3>Es gibt noch keine Bücher!</h3>";
                   }
                       // ++$count;
                    //endforeach;
                ?>
                    <!-- TODO: Change color of horizontal line -->
                <hr class="text-decoration-line-through">

                <!-- This row shows the status of the total capacity and amount of books of all warehouses. -->
                <!-- And it shows the capacity and number of books in every warehouse -->
                <div class="row align-items-center">
                        <div class="col">
                            <h2 class="h2">Status aller Buchlager:</h2>
                        </div>
                        <div class="col">
                            <?php echo $totalBooks . " / " . $totalCapacity . " Bücher"; ?>
                        </div>
                        <div class="col">
                            <div class="progress" style="width: 75%;">
                                <div class="progress-bar progress-bar-striped"
                                     role="progressbar"
                                     style="width: <?php echo $totalBooksInPercent; ?>%"
                                     aria-valuenow="<?php echo $totalBooksInPercent; ?>"
                                     aria-valuemin = "0"
                                     aria-valuemax= "100">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
    </body>
</html>
