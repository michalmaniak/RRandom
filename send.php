<?php
include("connect.php");
$i=0;
error_reporting(E_ALL);

$date=date('Y-m-d H:i:s');
//Walidacja parametrów else error
if($_POST['min']>=$_POST['max'])
    {
        echo "Error min>max";
    }elseif($_POST['min']<1 or $_POST['max']>100 or 10<$_POST['amount'] or 1>$_POST['amount'])
{
echo "Error Out of range";
}
elseif($_POST['amount']<=($_POST['max']-$_POST['min']))
{
    if($_POST['is_unique'])
    {
$values=range($_POST['min'], $_POST['max']);
shuffle($values);
        $range="<".$_POST['min'].", ".$_POST['max'].">";
        while($i<$_POST['amount']) {
            $query = $conn->prepare("INSERT INTO `results` (`id`, `userID`, `value`, `randomRange`, `isUNIQ`, `date`, `ip` )
            VALUES ('', 123, ?, ?, ?, ?, ?);");
            $query->bind_param('isiss',
                $values[$i], $range, $_POST['is_unique'], $date, $_SERVER['REMOTE_ADDR']); // binding parameters via a safer way than via direct insertion into the query. 'i' tells mysql that it should expect an integer.

            $query->execute();
            $error= $query->errorInfo();
            print_r($error);
            $query->close();
            echo $values[$i]."<br>";
            $i=$i+1;
        }
    }else {
        while($i<$_POST['amount']) {
            echo random_int($_POST['min'], $_POST['max']) . "<br>";
           //echo $i;
            $i=$i+1;
        }
    }
}else
{
    echo "Error, small amount";
}


?>