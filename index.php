<!-- HTML do site -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParlPlus</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Fonte do google - Topo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>
<body>
    <div id="geral">
        <div id="topo">
            <?php include "partes/topo.php"?>
        </div>
        <div id="menu">
            <?php include "partes/menu.php"?>
        </div>
        <div id="conteudo">
            <?php include "partes/conteudo.php"?>
        </div>
        <div id="rodape">
            <?php include "partes/rodape.php"?>
        </div>
    </div>
</body>
</html>