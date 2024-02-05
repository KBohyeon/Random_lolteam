<?php
$conn = mysqli_connect('localhost', 'root', '1234', 'lolteam');

// POST로 전달받은 데이터
$newname = $_POST['newname'];


print_r($newname);
    $Win = 0;
    $Lose = 0;
    $Sum = 0;
// 중복된 이름이 없다면 데이터베이스에 삽입
if (!$row) {
    $insert_sql = "INSERT INTO base (Name, Win, Lose, Sum) VALUES ('" . $name . "', '" . $Win . "', '" . $Lose . "', '" . $Sum . "')";
    mysqli_query($conn, $insert_sql);
    echo "success";
} else {
    echo "duplicate";
}

// 데이터베이스 연결 닫기
?>