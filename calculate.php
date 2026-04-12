<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

if (isset($_POST['course'], $_POST['credits'], $_POST['grade'])) {

    $student = $_POST['student_name'];
    $semester = $_POST['semester'];

    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades  = $_POST['grade'];

    $totalPoints = 0;
    $totalCredits = 0;

    for ($i = 0; $i < count($courses); $i++) {

        $cr = floatval($credits[$i]);
        $g  = floatval($grades[$i]);

        if ($cr <= 0) continue;

        $totalPoints += $cr * $g;
        $totalCredits += $cr;
    }

    if ($totalCredits > 0) {

        $gpa = $totalPoints / $totalCredits;

        $_SESSION['history'][] = [
            'student' => $student,
            'semester' => $semester,
            'gpa' => round($gpa, 2),
            'time' => date('Y-m-d H:i:s')
        ];

        echo json_encode([
            'success' => true,
            'gpa' => $gpa,
            'history' => $_SESSION['history']
        ]);

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid input'
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Data not received'
    ]);
}
