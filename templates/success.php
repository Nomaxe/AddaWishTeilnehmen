<!DOCTYPE html>
<html>
    <head lang="de">
        <title>AddaWish - Teilnehmen</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="../../assets/bilder/addawish.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="../../assets/bilder/addawish.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../assets/fonts/font-awesome-4.3.0/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="../../assets/css/success.css">
        <script language="JavaScript" type="text/javascript" src="../../assets/js/jquery-1.11.2.min.js"></script>
        <script language="JavaScript" type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="row" id="header">
                    <div class="col-md-4">
                        <h1>
                            <a href="http://www.addawish.de">
                                <img src="../../assets/bilder/add-a-wish.jpg" alt="AddaWish Logo" title="AddaWish">
                            </a>
                        </h1>
                    </div>
                    <div class="col-md-2">
                        <h2>
                            Poolname:
                        </h2>
                        <p>
                            <?php echo $pool->getName(); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-12" id="slider">
                            <?php echo '<p class="momentan" id="momentan" style="width:' . $pool->getErreichtProzent($teilbetrag) . '">'; ?>
                                <?php echo 'Erreicht: '. $pool->getErreichtEuro(); ?>
                            </p>
                            <div class="progress progress-striped" id="progressbar">
                                <?php echo '<div class="progress-bar progress-bar-custom active" role="progressbar" style="width: ' . $pool->getErreichtProzent(0) . '">'; ?>
                                </div>
                            </div>
                        <?php echo '<p class="maximal" style="width: ' . $pool->getZielProzent($teilbetrag) . ';" id="prozent100">'; ?>
                            <?php echo 'Zielbetrag: ' . $pool->getZiel() . '€'; ?>
                        </p>
                        </div>
                    </div>
                </div>
                <div id="vielenDank">
                    <h2>
                        Vielen Dank das du am Pool <?php echo $pool->getName(); ?> teilgenommen hart
                    </h2>
                </div>
                <div id="startPunkte">
                    <h4>Starte jetzt deinen eigenen Pool</h4>
                    <a href="http://www.addawish.de"><img src="../../assets/bilder/platzhalter.png" alt="Startpunkt 1"></a>
                    <a href="http://www.addawish.de"><img src="../../assets/bilder/platzhalter.png" alt="Startpunkt 2"></a>
                    <a href="http://www.addawish.de"><img src="../../assets/bilder/platzhalter.png" alt="Startpunkt 3"></a>
                    <a href="http://www.addawish.de"><img src="../../assets/bilder/platzhalter.png" alt="Startpunkt 4"></a>
                    <a href="http://www.addawish.de"><img src="../../assets/bilder/platzhalter.png" alt="Startpunkt 5"></a>
                </div>
                <div id="freundeEinladen">
                    <h4>Lage jetzt deine Freunde zu diesem Pool ein</h4>
                    <?php echo '<input type="text" value="' . $pool->getUrl() .'" size="80">'; ?>
                </div>
            </div>
        </div>
    </body>
</html>