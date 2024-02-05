<?php
// db_conn.php
$host = 'localhost';
$user = 'root';
$password = '1234';
$dbname = 'transportationperformance';

$conn = mysqli_connect("localhost", "root", "1234", "lolteam");
//레드 팀이 이겼을 경우 

// POST로 전달된 데이터 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonString = $_POST['winMember'];
	$jsonString1 = $_POST['loseMember'];

    // JSON 문자열을 배열로 변환
    $winmemberArray = json_decode($jsonString, true);
	$losememberArray = json_decode($jsonString1, true);

    //이겼을때와 졌을 때를 구분해서 넣어야함
    print_r($winmemberArray);
	for($a=0;$a<5;$a++){
	$Name = $winmemberArray[$a];
	$Win = 1;
	$Lose = 0;
	$query = "INSERT INTO base (Name, Win, Lose) 
	VALUES ('" . $Name ."', '" . $Win . "', '" . $Lose . "')";
	mysqli_query($conn, $query);
}
for($a=0;$a<5;$a++){
	$Name = $losememberArray[$a];
	$Win = 0;
	$Lose = 1;
	$query = "INSERT INTO base (Name, Win, Lose) 
	VALUES ('" . $Name ."', '" . $Win . "', '" . $Lose . "')";
	mysqli_query($conn, $query);
}
} else {
    // POST 요청이 아닌 경우 에러 메시지 출력
    echo "Invalid request method!";
}
?>