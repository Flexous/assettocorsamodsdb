<?php

try
{
    $dir = 'sqlite:db\mods.db';
    $con=new PDO($dir);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo 'connected';
}
catch(PDOException $e)
{
    echo '<br>'.$e->getMessage();
}

$searchErr = '';
$team_details='';
$driver_details='';
if(isset($_POST['save']))
{
    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];
        $stmt = $con->prepare("select * from teams where name like '%$search%'");
        $stmt->execute();
        $team_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $con->prepare("select * from drivers where name like '%$search%'");
        $stmt->execute();
        $driver_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        $searchErr = "Please enter the information";
    }
}

?>