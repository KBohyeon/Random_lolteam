<!DOCTYPE html>
<html lang="en">
    <?php
    ini_set('display_errors', '0');
    include "db_conn.php";
    $Name = '';
    $Win = '';
    $Lose = '';
    $Rating = '';
    ?>
<head>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>롤 내전 팀 짜기</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* 공백 없이 화면 다쓰기 */
        .container-fluid{ 
            flex: 1;
            display: flex;
            padding: 0;

        }

        .left-panel, .right-panel {
            box-sizing: border-box;
            padding: 20px;
        }

        .left-panel {
            flex: 1;
            background-color: #f0f0f0;
        }

        .left-section {
            flex: 1;
            margin-bottom: 20px;
        }

        .right-panel {
            flex: 2;
            background-color: #e0e0e0;
            display: flex;
            flex-direction: column;
        }

        .right-section {
            flex: 1;
            margin-bottom: 20px;
        }

        .teams-container {
            display: flex;
            justify-content: space-around;
        }

        .team {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .result-buttons {
            display: flex;
            justify-content: space-around;
        }

        table, th, td {
            border: 1px solid #007bff;
        }

        form {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <div class="container-fluid">
        <div class="left-panel">
            <!-- 왼쪽 패널의 내용 -->
            <h2>롤 내전 팀 짜기</h2>
            <div class="left-section">               
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <div class="form-section">
                        <label for="name<?= $i ?>">이름 <?= $i ?>:</label>
                        <input type="text" list="nameSearch" id="name<?= $i ?>" name="name<?= $i ?>" />
                        <datalist id="nameSearch">
                            <?php 
                            $conn = mysqli_connect("localhost", "root", "1234", "lolteam");
                            $result = mysqli_query($conn, "SELECT * FROM base");
                            while ($row = mysqli_fetch_array($result)) {
                                $name = $row['Name'];?>
                                <option value="<?php echo $name; ?>"></option>
                                <?php  } ?> 
                        </datalist>
                        <input style="zoom:1.5;" type="checkbox" id="check<?= $i ?>" name="check<?= $i ?>" onchange="limitCheckboxes()" />
                        <label for="check<?= $i ?>">체크</label>
                    </div>
                <?php endfor; ?>
                                            
                <button class="btn btn-primary btn-lg" onclick="createTeams()">팀 짜기</button>
                <button class="btn btn-primary btn-lg" onclick="createTeams()">10번 섞기</button>
                <!-- <button class="btn btn-primary btn-lg" onclick="rating()">승률 업데이트</button> -->
                <input type="submit" class="btn btn-success btn-lg" name="update" value="승률 업데이트">
            </div>

            <div class="left-section">
                <h2>이름 추가</h2>
                <div class ="form-section">
                    <label for="name">이름:</label>
                        <input type="text" id="name" name="name" />
                </div>
                <div>
                    <button class="btn btn-primary" onclick="createName()">추가하기</button>
                </div>
            </div>

            <script>
                var count = 0;
                var readTeam;
                function limitCheckboxes() {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    var checkedCount = 0;

                    checkboxes.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            checkedCount++;
                        }
                    });

                    // 이미 2개 이상 선택된 경우 나머지 체크박스를 비활성화
                    checkboxes.forEach(function (checkbox) {
                        checkbox.disabled = checkedCount >= 2 && !checkbox.checked;
                    });
                }

                //이름 추가
                function createName() {
                    var newname = document.getElementById('name').value;

                    $.ajax({
                    type: "POST",
                    url: "insert.php",
                    data: {
                        newname: newname,
                    },
                    dataType: "text",
                        success: function (result) {
                        console.log(result);

                        const Toast = Swal.mixin({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,

                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                        });

                            if (result === "success") {
                                Toast.fire({
                                    icon: 'success',
                                    title: newname + ' 이름을 추가 했어요.  '
                                });
                            } 

                            else if (result === "duplicate") {
                                Swal.fire({
                                    icon: 'error',
                                    title: newname + '은(는) 등록 되어 있는 이름 이에요.',
                                    text: '',
                                });
                            }
                        }
                    });
                }
                
                function createTeams() {
                    count =0;
                    var names = [];
                    var checkedNames = [];

                    // 모든 텍스트 박스의 값을 배열에 추가
                    for (var i = 1; i <= 10; i++) {
                        var nameValue = document.getElementById('name' + i).value;
                        names.push(nameValue);

                        // 체크된 체크 박스에 해당하는 이름을 따로 배열에 추가
                        var checkBox = document.getElementById('check' + i);
                        if (checkBox.checked) {
                            checkedNames.push(nameValue);
                        }
                    }

                    if (checkedNames.length >= 2) {
                        // 선택된 2명도 랜덤으로 팀에 배정
                        var shuffledCheckedNames = shuffleArray(checkedNames);
                        redTeam = [shuffledCheckedNames[0]];
                        blueTeam = [shuffledCheckedNames[1]];

                        // 나머지 팀원을 랜덤하게 팀에 배정
                        var remainingNames = names.filter(function (name) {
                            return name !== shuffledCheckedNames[0] && name !== shuffledCheckedNames[1];
                        });

                        // 팀 짜기 로직
                        var shuffledNames = shuffleArray(remainingNames);
                        redTeam = redTeam.concat(shuffledNames.slice(0, 4));
                        blueTeam = blueTeam.concat(shuffledNames.slice(4, 8));
                    } 

                    else {
                        // 아무도 선택되지 않은 경우 모든 팀원을 랜덤하게 팀에 배정
                        var shuffledNames = shuffleArray(names);
                        redTeam = shuffledNames.slice(0, 5);
                        blueTeam = shuffledNames.slice(5, 10);
                    }

                    // 미드, 정글, 탑, 원딜, 서폿 랜덤 배정
                    var positions = ['미드', '정글', '탑', '원딜', '서폿'];
                    shuffleArray(positions);

                    // 결과를 오른쪽 섹션 1에 표시
                    var resultHTML = '<div class="teams-container">';
                    resultHTML += '<div class="team">';
                    resultHTML += '<h3>레드 팀</h3>';
                    for (var i = 0; i < redTeam.length; i++) {
                        resultHTML += '<p>' + redTeam[i] + ' - ' + positions[i] + '</p>';
                    }
                    resultHTML += '</div>';
                    resultHTML += '<div class="team">';
                    resultHTML += '<h3>블루 팀</h3>';
                    for (var i = 0; i < blueTeam.length; i++) {
                        resultHTML += '<p>' + blueTeam[i] + ' - ' + positions[i] + '</p>';
                    }
                    resultHTML += '</div>';
                    resultHTML += '</div>';

                    // 레드팀 승리, 블루팀 승리 버튼
                    resultHTML += '<div class="result-buttons">';
                    resultHTML += '<button class="btn btn-primary" onclick="declareWinnerRed()">레드팀 승리</button>';
                    resultHTML += '<button class="btn btn-primary" onclick="declareWinnerBlue()">블루팀 승리</button>';
                    resultHTML += '</div>';

                    document.getElementById('teamResult').innerHTML = resultHTML;
                }

                //레드팀 승리 저장 팀짜기를 다시 눌러야 저장 가능
                function declareWinnerRed() {
                    if(count==0) {
                        Swal.fire({
                            title: '레드 팀의 승리로 저장 할까요?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '그러죠',
                            cancelButtonText: '싫어요'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                //레드 팀이 이겼을 경우
                                count= +1;
                                var winMember = JSON.stringify(redTeam); 
                                var loseMember = JSON.stringify(blueTeam);
                                $.ajax({ 
                                    type:"POST", 
                                    url:"blueTeam.php",
                                    traditional : true,
                                    data: {
                                        winMember: winMember,
                                        loseMember: loseMember,
                                    },

                                    success:function(result){ 
                                        console.log(result);
                                    }
                                });

                                Swal.fire(
                                    '저장되었어요.',
                                    '데이터 쌓이는 중...',
                                    'success'
                                )
                            }
                        }) 
                    } 

                    else if(count!=0) {
                        alert('이미 저장 했어요');   
                    }                                                      
                }

                //블루팀 승리 저장
                function declareWinnerBlue() {
                    if(count == 0) {
                        Swal.fire({
                        title: '블루 팀의 승리로 저장 할까요?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '그러죠',
                        cancelButtonText: '싫어요'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                //블루 팀이 이겼을 경우
                                count= +1;
                                var winMember = JSON.stringify(blueTeam); 
                                var loseMember = JSON.stringify(redTeam);
                                $.ajax({ 
                                    type:"POST", 
                                    url:"blueTeam.php",
                                    traditional : true,
                                    data: {
                                        winMember: winMember,
                                        loseMember: loseMember,
                                    },

                                    success:function(result){ 
                                        console.log(result);
                                    }
                                });

                                Swal.fire(
                                    '저장되었어요.',
                                    '데이터 쌓이는 중...',
                                    'success'
                                )
                            }
                        }) 
                    }

                    else if(count!=0) {
                        alert('이미 저장 했어요');   
                    }
                }
                
                // 배열을 랜덤하게 섞는 함수
                function shuffleArray(array) {
                    var currentIndex = array.length, randomIndex, tempValue;

                    while (currentIndex !== 0) {
                        randomIndex = Math.floor(Math.random() * currentIndex);
                        currentIndex--;
                        tempValue = array[currentIndex];
                        array[currentIndex] = array[randomIndex];
                        array[randomIndex] = tempValue;
                    }
                    return array;
                }
            </script>
        </div>
        <div class="right-panel">
            <!-- 오른쪽 패널 내용 -->
            <div class="right-section" id="teamResult">
                <h3>팀 짜기 결과</h3>
                <p>팀 짜기 버튼을 눌러 결과를 확인하세요.</p>
            </div>
            <div class="right-section" style="display: flex;">
                <div style="flex: 2;">
                    <h3>설명서</h3>
                    <p>자동완성에 이름이 있어야 데이터가 저장이 돼요.</p>
                    <p>자동완성에 이름이 뜨지 않는다면 이름을 추가하고 새로고침을 눌러서 뜨는지 확인 해주세요.</p>
                    <p>체크 박스에 체크 된 2명은 같은 팀이 될 수 없고 맞라인을 서게 되어있어요.(동일팀 회피)</p>
                </div>
                
                <div style="flex: 1;" id="rating">
                    <h3>RATING</h3>
                    <table class="table mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th>이름</th>
                                <th>승리</th>
                                <th>패배</th>
                                <th>승률</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $conn = mysqli_connect("localhost", "root", "1234", "lolteam");
                                //승률이 높은 순으로 5명 검색기능? 추가하기
                                $result = mysqli_query($conn, "SELECT * FROM base ORDER BY Rating DESC");
                                $sql_count = 0;
                                while ($row = mysqli_fetch_array($result)) {
                                    $Name = $row['Name'];
                                    $Win = $row['Win'];
                                    $Lose = $row['Lose'];
                                    $Rating = $row['Rating'];
                            ?>
                                <tr>
                                    <td><?php echo $Name; ?></td>
                                    <td><?php echo $Win; ?></td>
                                    <td><?php echo $Lose; ?></td>
                                    <td><?php echo $Rating;?>%</td>
                                </tr>
                            <?php
                            $sql_count++;
                            echo '<script>';
                            echo 'console.log("'.$sql_count.'")';
                            echo '</script>';
                                if($sql_count>=5){
                                    echo '<script>';
                                    echo 'console.log("stop")';
                                    echo '</script>';
                                    break;
                                }
                            }
                            ?>
                            <!-- 검색기능 만들다가 멈춤 -->
                            <form method="POST" action="">
                                <div class="form-row align-items-center">
                                    <div class="col-md-3">
                                        <label for="serialNumber" class="sr-only">이름:</label>
                                        <input type="text" class="form-control" name="serialNumber" id="serialNumber" value="<?php echo $serialNumber; ?>" placeholder="이름">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-primary" value="검색">
                                    </div>
                                </div>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
