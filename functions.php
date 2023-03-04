<?php
function connectToDbAndReturnConnection()
{
    $dir = 'sqlite:db\mods.db';
    $con=new PDO($dir);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $con;
}

function getSeriesLogo($id)
{
    if ($id === null)
    {
        return 'img/logo.png';
    }

    settype($id, 'integer');

    $dir = 'sqlite:db\mods.db';
    $con=new PDO($dir);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare("select logo from series where id = $id");
    $stmt->execute();
    $flag = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($flag)
    {
        foreach ($flag as $key => $value)
        {
            return $value['logo'];
        }
    }
}
?>