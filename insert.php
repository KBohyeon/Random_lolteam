<?php
$conn = mysqli_connect('localhost', 'root', '1234', 'lolteam');

// POST로 전달받은 데이터
$newname = $_POST['newname'];

// 중복 체크 쿼리
$sql = "SELECT * FROM base WHERE Name='$newname'";
$result = mysqli_query($conn, $sql);

// 결과 배열로 변환
$row = mysqli_fetch_array($result);
$name = $newname;
    $Win = 0;
    $Lose = 0;
    $Sum = 0;
    $Rating = 0;
// 중복된 이름이 없다면 데이터베이스에 삽입
if (!$row) {
    $insert_sql = "INSERT INTO base (Name, Win, Lose, Sum, Rating) VALUES ('" . $name . "', '" . $Win . "', '" . $Lose . "', '" . $Sum . "', '" . $Rating . "')";
    mysqli_query($conn, $insert_sql);
    echo "success";
} else {
    echo "duplicate";
}

// 데이터베이스 연결 닫기
?>