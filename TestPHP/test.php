<?php
$name="";
$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST["name"];
    if($name=="Adam"){
        $message="Vítej, Adame!";
    }else{
        $message="Neznám tě, $name!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PHP</title>
</head>
<body>
    <h1>Test formuláře</h1>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit ipsum odit ipsa, atque molestias officia eveniet non exercitationem expedita aliquam animi alias eum tempore maxime? Libero nobis corporis neque repudiandae!</p>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit ipsum odit ipsa, atque molestias officia eveniet non exercitationem expedita aliquam animi alias eum tempore maxime? Libero nobis corporis neque repudiandae!</p>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Velit ipsum odit ipsa, atque molestias officia eveniet non exercitationem expedita aliquam animi alias eum tempore maxime? Libero nobis corporis neque repudiandae!</p>
    <form method="post">
        <input type="text" name="name" placeholder="Zadejte své jméno">
        <input type="number" name="age" placeholder="Zadejte svůj věk">
        <button type="submit">Odeslat</button>
    </form>
    
    <p><?php echo $message; ?></p>
    <p><?php echo "Věk: " . $_POST["age"]; ?></p>
</body>
</html>