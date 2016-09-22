<?php


include 'conn.php';


$query = "Select name From budget Group By name";

$result = mysqli_query(GetMyConnection(),$query);

//        //$records = [];
//        while($row = mysqli_fetch_assoc($result)) {
//            $records[] = $row["name"];
//        }

while ($row = mysqli_fetch_assoc($result)) {
    $rows[$row['name']] = $row['name'];
}
mysqli_free_result($result);

echo json_encode($rows);
