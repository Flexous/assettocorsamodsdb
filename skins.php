<?php

require_once('functions.php');

$con = connectToDbAndReturnConnection();

$searchErr = '';
$team_details='';
$skin_details='';
if(isset($_POST['save']))
{
    if(!empty($_POST['search']))
    {
        $search = $_POST['search'];
        $stmt = $con->prepare("select * from skins where display_name like '%$search%'");
        $stmt->execute();
        $skin_details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        $searchErr = "Please enter the information";
    }
}

?>

<html>

<?php include('header.php') ?>

<body>
<div class="container">
    <form class="form-horizontal" action="#" method="post" style="color: white; border-bottom: 1px solid white">
        <div class="row">
            <div class="form-group">
                <label class="control-label col-sm-4" for="email"><b>Search skin(s):</b></label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="search" value="<?php echo isset($_POST['search']) ? $_POST['search'] : '' ?>">
                    <button type="submit" name="save" class="btn btn-success btn-sm">Submit</button>
                </div>
            </div>
            <div class="form-group">
                <span class="error" style="color:red;">* <?php echo $searchErr;?></span>
            </div>

        </div>
    </form>
    <br/><br/>
    <div style="width: 50%">
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
                        <td style="width: 400px"><img style="width: 50%; height: 50%" src="img/skins/<?php echo $value['preview_picture'];?>"></td>
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
