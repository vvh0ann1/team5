<!DOCTYPE html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="./css/style.css">
<style>
.close { margin:20px 0 0 120px; cursor:pointer; }
.warning { color: red; margin-top: 5px; }
.highlight { color: red; font-weight: bold; } /* 강조 표시를 위한 스타일 */
</style>
</head>
<body>
   <h3>아이디 중복 체크</h3>
   <div>
<?php
   $id = $_GET["id"];

   // 아이디 입력 확인
   if (!$id) {
       echo("<p class='warning'>아이디를 입력해 주세요!</p>");
   } 
   // 아이디 유효성 검사 (5~15자, 영문 포함, 특수문자 허용)
   elseif (!preg_match("/^(?=.*[a-zA-Z])[a-zA-Z0-9_!@#\$%\^&\*]{5,15}$/", $id)) {
       echo("<p class='warning'>아이디는 반드시 영문자를 포함하고, <span class='highlight'>숫자, 밑줄(_), 또는 특수기호(!@#$%^&*)</span>를 포함한 5~15자리여야 합니다.</p>");
   } 
   else {
       // DB 연결
       $con = mysqli_connect("localhost", "min", "guseodhxhdpqj@", "project");
       
       if (mysqli_connect_errno()) {
           echo "<p class='warning'>연결에 실패하였습니다. 나중에 다시 시도해 주세요.</p>";
           exit();
       }

       // Prepared Statement를 사용하여 SQL 인젝션 방지
       $stmt = $con->prepare("SELECT * FROM members WHERE id = ?");
       $stmt->bind_param("s", $id);
       $stmt->execute();
       $result = $stmt->get_result();

       $num_record = $result->num_rows;

       // 아이디 중복 확인 결과 처리
       if ($num_record) {
           echo "<p class='warning'>" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . " 아이디는 중복됩니다.</p>";
           echo "<p>다른 아이디를 사용해 주세요!</p>";
       } else {
           echo "<p>" . htmlspecialchars($id, ENT_QUOTES, 'UTF-8') . " 아이디는 사용 가능합니다.</p>";
       }
       
       // 자원 해제 및 DB 연결 종료
       $stmt->close();
       mysqli_close($con);
   }
?>
   <div class="close">
      <button type="button" onclick="javascript:self.close()">창 닫기</button>
   </div>
   </div>
</body>
</html>
