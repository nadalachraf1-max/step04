<?php
header('Content-Type: application/json');
include "db.php";

$student = $_POST['student'];
$semester = $_POST['semester'];

$courses = $_POST['course'];
$credits = $_POST['credits'];
$grades = $_POST['grade'];

$totalPoints = 0;
$totalCredits = 0;

$tableHtml = "<table class='table table-bordered mt-3'>";
$tableHtml .= "<tr>
<th>Course</th>
<th>Credits</th>
<th>Grade</th>
<th>Points</th>
</tr>";

for($i=0;$i<count($courses);$i++){

$course = htmlspecialchars($courses[$i]);
$cr = floatval($credits[$i]);
$g = floatval($grades[$i]);

$pts = $cr * $g;

$totalPoints += $pts;
$totalCredits += $cr;

$tableHtml .= "<tr>
<td>$course</td>
<td>$cr</td>
<td>$g</td>
<td>$pts</td>
</tr>";

}

$tableHtml .= "</table>";

$gpa = $totalPoints/$totalCredits;

for($i=0;$i<count($courses);$i++){

$sql="INSERT INTO gpa_results
(student_name,semester,course,credits,grade,gpa)
VALUES (?,?,?,?,?,?)";

$stmt=$conn->prepare($sql);

$stmt->bind_param(
"sssddd",
$student,
$semester,
$courses[$i],
$credits[$i],
$grades[$i],
$gpa
);

$stmt->execute();
}

echo json_encode([
"success"=>true,
"gpa"=>$gpa,
"message"=>"GPA = ".number_format($gpa,2),
"tableHtml"=>$tableHtml
]);
?>
     
