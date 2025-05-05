# 🔍 Random_lolteam

**Random_lolteam**은 5대5 게임시 10명을 랜덤으로 팀 및 역할배정을 도와주는 웹 사이트 입니다.

## 🖥️ 프로젝트 개요

- 🧩 **개발 환경**: XAMPP (Apache + MySQL)
- 🛠️ **구현 방식**: PHP 기반 웹 사이트
- 🗃️ **데이터베이스**: MySQL
- 🎯 **주요 기능**:
  - 10명의 팀원 팀 및 역할 배정
  - 승률 저장
  - 승률 표시

---

## ⚙️ 기술 스택

| 구성 요소      | 사용 기술                |
|----------------|--------------------------|
| 백엔드         | PHP, MySQL               |
| 프론트엔드     | HTML, CSS, JavaScript    |
| 서버           | Apache(XAMPP)          |
| 데이터베이스    | MySQL                    |

---

## 🚩 실행 시 꼭 읽어주세요!
1. **XAMPP 설치**
- [XAMPP 공식 사이트](https://www.apachefriends.org/index.html)

3. **프로젝트 파일 복사**
- 파일을 `htdocs` 디렉터리에 파일을 만들어 복사합니다.

5. **MySql 데이터베이스 설정**
- XAMPP Control Panel에서 Apache 실행 
- 스키마, 테이블을 미리 생성해주셔여 합니다.
- 스키마 이름: lolteam
- 테이블 이름: base

4. **사이트 접속**
- upload.html에 접속해 파일을 업로드 합니다.

5. **주의 사항!!**
- 엑셀파일 .xlsx가 아닌 .csv로 확장자 명을 바꿔서 업로드 해야합니다.
- .csv 변경시 전화번호가 깨질경우 사이트내에서 자동으로 바뀌게 했으니 무시하셔도 됩니다.
- 한글이 깨질시 메모장으로 열고 UTF-8로 변경해야합니다.

--

## 🌄 화면 미리보기

Random_lolteam의 주요 화면들을 아래에서 확인하실 수 있습니다.

<table>
  <tr>
    <td align="center"><b>🏠 메인 페이지</b></td>
    <td align="center"><b>📱 모바일 페이지</b></td>
  </tr>
  <tr>
    <td><img src="./images/메인페이지.png" width="100%"></td>
    <td><img src="./images/메인페이지 모바일.png" width="100%"></td>
  </tr>
  <tr>
    <td align="center"><b>📄 상세페이지1</b></td>
    <td align="center"><b>📄 상세페이지 지도</b></td>
  </tr>
  <tr>
    <td><img src="./images/상세페이지1.png" width="100%"></td>
    <td><img src="./images/상세페이지 지도.png" width="100%"></td>
  </tr>
  <tr>
    <td align="center"><b>📄 상세페이지 식당 정보</b></td>
    <td align="center"><b>📄 상세페이지 리뷰</b></td>
  </tr>
  <tr>
    <td><img src="./images/상세페이지 식당 정보.png" width="100%"></td>
    <td><img src="./images/상세페이지 리뷰.png" width="100%"></td>
  </tr>
    <tr>
    <td align="center"><b>🔍 검색페이지</b></td>
    <td align="center"><b>💾 DB</b></td>
  </tr>
  <tr>
    <td><img src="./images/검색페이지.png" width="100%"></td>
    <td><img src="./images/데이터베이스.png" width="100%"></td>
  </tr>
</table>

---

## 📌 향후 개선 방향

- 1.5km내 랜덤 식당 추천
- 리뷰 등록시 영수증 리뷰 추가

---

## 📮 문의

- 디자인: **김보현**
- 백엔드, 프론트 개발자: **김보현**  
- 이메일: `qhgus9346@gmail.com`
