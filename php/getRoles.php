<?php
include 'conn.php';
$result = mysqli_query(GetMyConnection(), "Select id,name From departments");
if ($result) {
    $departments = "";
    while ($row = mysqli_fetch_assoc($result)) {
        $departments.='<option data-content="' . $row["name"] . '">' . $row["id"] . '</option>';
    }
} else {
    die("Couldn't get departments: " . mysql_error());
}

$result2 = mysqli_query(GetMyConnection(), "Select id,name From roles");
if ($result2) {
    $roles = "";
    while ($row = mysqli_fetch_assoc($result2)) {
        $roles.='<option data-content="' . $row["name"] . '">' . $row["id"] . '</option>';
    }
} else {
    die("Couldn't get roles: " . mysql_error());
}
$json["departments"] = $departments;
$json["roles"] = $roles;
echo json_encode($json);
