<?php

require_once('functions.php');

$con = connectToDbAndReturnConnection();

$searchErr = '';
$skin_details='';
if(isset($_POST['submit']))
{
    $query = "";

    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];
        $query = "select * from skins where display_name like '%$search%'";

        if ($_POST['value'] && empty($_POST['year']))
        {
            $selected_series = $_POST['value'];

            $query = "select * from skins where display_name like '%$search%' and series = $selected_series";
        }
        else if ($_POST['year']&& empty($_POST['value']))
        {
            $selected_year = $_POST['year'];

            $query = "select * from skins where display_name like '%$search%' and year = $selected_year";
        }
        else if ($_POST['value']&& $_POST['year'])
        {
            $selected_series = $_POST['value'];
            $selected_year = $_POST['year'];

            $query = "select * from skins where display_name like '%$search%' and series = $selected_series and year = $selected_year";
        }
    }
    else if ($_POST['value'])
    {
        $selected_series = $_POST['value'];
        $query = "select * from skins where series = $selected_series";

        if ($_POST['year'])
        {
            $selected_year = $_POST['year'];

            $query = "select * from skins where series = $selected_series and year = $selected_year";
        }
    }
    else if (empty($_POST['value']) && $_POST['year'])
    {
        $selected_year = $_POST['year'];
        $query = "select * from skins where year = $selected_year";
    }

    $stmt = $con->prepare($query);
    $stmt->execute();
    $skin_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<html>

<?php include('header.php') ?>

<body>
<div class="container">
    <form class="form-horizontal" action="#" method="post" style="color: white; border-bottom: 1px solid white">
        <div class="row">
            <div class="form-group">
                <label class="control-label"><b>Search skin(s):</b></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="search" value="<?php echo isset($_POST['search']) ? $_POST['search'] : '' ?>">
                    <br><br>
                    <label class="control-label"><b>Filter by series:</b></label>
                    <br>
                    <select name="value" id="selectSeries">
                        <option value="">Select an option</option>
                    <?php
                    require_once('functions.php');
                    $series = getSeries();

                    if ($series)
                    {
                        foreach ($series as $key => $value)
                        {
                            ?>
                            <option <?php if (isset($_POST['value']) && $_POST['value'] == $value['id']) echo "selected='selected'" ?>value="<?php echo $value['id'];?>"><?php echo $value['display_name'];?></option>
                            <?php
                        }
                    }

                    ?>
                    </select>
                    <br><br>
                    <label class="control-label"><b>Filter by year:</b></label>
                    <br>
                    <input autocomplete="on" name="year" type="number" min="1950" max="2023" step="1" value="<?php echo isset($_POST['year']) ? $_POST['year'] : '2023' ?>" />
                    <br><br>
                    <button type="submit" name="submit" class="btn btn-success btn-sm">Submit</button>
                </div>
            </div>
        </div>
    </form>
    <br/><br/>
    <div style="width: 100%">
        <table>
            <tbody>
            <?php
            if($skin_details)
            {
                foreach($skin_details as $key=> $value)
                {
                    ?>
                    <tr>
                        <td style="width: 500px"><a style="text-decoration: none; color: white" target="_blank" href="<?php echo $value['link'];?>"><?php echo $value['display_name'];?></a></td>
                        <td style="width: 400px"><img style="width: 50%; height: 50%" src="img/skins/<?php echo $value['preview_picture'];?>.png"></td>
                    </tr>

                    <?php
                }
            }
            ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>
