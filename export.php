<?php
include "db.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="gpa.csv"');

$output=fopen("php://output","w");

fputcsv($output,
["Student","Semester","Course","Credits","Grade","GPA"]);

$result=$conn->query("SELECT * FROM gpa_results");

while($row=$result->fetch_assoc()){
fputcsv($output,$row);
}

fclose($output);
?>
