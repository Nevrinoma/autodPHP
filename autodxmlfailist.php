<?php
$autod=simplexml_load_file('Autod.xml');
//otsing
function otsiAutonumberiJargi_($paring){
    global $autod;
    $vastus=array();
    foreach ($autod->auto as $auto){
        if (
                substr(strtolower($auto->autonumber),0,strlen($paring))==strtolower($paring)){
                array_push($vastus, $auto);
        }

    }
    return $vastus;
}

$years = [];
foreach ($autod->auto as $auto) {
    $years[] = (int)$auto->valjAaasta;
}
rsort($years);
$yearsString = implode(', ', $years);


?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>Autod xml failist</title>
    <meta charset="utf-8">
</head>
<body>
<h1>Autod xml failist</h1>

<?php
echo "Esimene autonumber ";
echo $autod->auto[0]->autonumber;
echo "<br>";
echo "<strong>Kõik autod</strong>";
foreach ($autod->auto as $auto){
    echo $auto->autonumber." ";
    echo $auto->mark." ";
    echo $auto->valjAaasta." ";
    echo $auto->omanik.", ";
}
?>
<br>
<form action="?" method="post">
    <label for="otsing">Otsing</label>
    <br>
    <input type="text" id="otsing" name="otsing" placeholder="Autonumber:">
    <input type="submit" value="Otsi">

</form>
<br>
<?php
if (!empty($_POST["otsing"])){
    $vastus=otsiAutonumberiJargi_($_POST["otsing"]);
    echo "<table>";
    echo "<tr><th>Autonumber</th><th>Mark</th><th>Valja Aasta</th><th>Omanik</th></tr>";
    foreach ($vastus as $auto){

        echo "<tr>";
        echo "<td>" . $auto->autonumber . "</td>";
        echo "<td>" . $auto->mark . "</td>";
        echo "<td>" . $auto->valjAaasta . "</td>";
        echo "<td>" . $auto->omanik . "</td>";

    }
    echo "</tr>";
    echo "</table>";
}
else{
    echo "<table>";
    echo "<tr><th>Autonumber</th><th>Mark</th><th>Valja Aasta</th><th>Omanik</th></tr>";
    foreach ($autod->auto as $auto) {
        echo "<tr>";
        echo "<td>" . $auto->autonumber . "</td>";
        echo "<td>" . $auto->mark . "</td>";
        echo "<td>" . $auto->valjAaasta . "</td>";
        echo "<td>" . $auto->omanik . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
echo "<br>";
echo "Годы выпуска в порядке убывания: " . $yearsString;

echo "Вывести в строчку имена владельцев через запятую, длина которых больше 5 символов";

$ownersWithLongNames = [];
foreach ($autod->auto as $auto) {
    $owner = $auto->omanik;
    if (strlen($owner) > 5) {
        $ownersWithLongNames[] = $owner;
    }
}
$longNamesString = implode(', ', $ownersWithLongNames);
echo "Имена: " . $longNamesString;
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, th, td {
        border: 1px solid #ccc;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</body>
</html>
