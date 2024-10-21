<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>오토에버 불여조</title>
<link rel="stylesheet" href="./css/style.css">
<script>
   var isIdChecked = false; // 아이디 중복 체크 여부 플래그

   function check_input() {
      // 아이디 입력 확인
      if (!document.member.id.value) {
          alert("아이디를 입력하세요!");    
          document.member.id.focus();
          return;
      }

      // 비밀번호 입력 확인
      if (!document.member.pass.value) {
          alert("비밀번호를 입력하세요!");    
          document.member.pass.focus();
          return;
      }

      // 비밀번호 확인 입력 확인
      if (!document.member.pass_confirm.value) {
          alert("비밀번호확인을 입력하세요!");    
          document.member.pass_confirm.focus();
          return;
      }

      // 이름 입력 확인
      if (!document.member.name.value) {
          alert("이름을 입력하세요!");    
          document.member.name.focus();
          return;
      }

      // 이메일 입력 확인
      if (!document.member.email.value) {
          alert("이메일 주소를 입력하세요!");    
          document.member.email.focus();
          return;
      }

      // 비밀번호와 비밀번호 확인이 일치하는지 확인
      if (document.member.pass.value != document.member.pass_confirm.value) {
          alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
          document.member.pass.focus();
          document.member.pass.select();
          return;
      }

      // 아이디 중복 체크 여부 확인
      if (!isIdChecked) {
          alert("아이디 중복 체크를 해주세요.");
          return;
      }

      // 모든 조건을 만족하면 폼 제출
      document.member.submit();
   }

   // 중복 체크 함수
   function check_id() {
      var xhr = new XMLHttpRequest();
      var id = document.member.id.value;
      
      if (!id) {
         alert("아이디를 입력하세요!");
         document.member.id.focus();
         return;
      }

      xhr.open("GET", "check_id.php?id=" + encodeURIComponent(id), true);
      xhr.onreadystatechange = function() {
         if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText.trim() === "fail") {
               alert("아이디가 중복되었습니다. 다른 아이디를 사용하세요.");
               isIdChecked = false; // 중복 체크 실패
               document.member.id.focus();
            } else {
               alert("아이디를 사용할 수 있습니다.");
               isIdChecked = true; // 중복 체크 성공
            }
         }
      };
      xhr.send();
   }

   // 폼 초기화 함수
   function reset_form() {
      document.member.id.value = "";  
      document.member.pass.value = "";
      document.member.pass_confirm.value = "";
      document.member.name.value = "";
      document.member.email.value = "";
      isIdChecked = false; // 폼 리셋 시 중복 체크 상태도 리셋
      document.member.id.focus();
      return;
   }

   // 이전 페이지로 돌아가기
   function go_back() {
      window.history.back();
   }
</script>
</head>
<body> 
    <form name="member" action="insert.php" method="post">
        <h2>회원 가입</h2>
        <ul class="join_form">
            <li>
                <span class="col1">아이디</span>
                <span class="col2"><input type="text" name="id"></span>
                <span class="col3"><button type="button" onclick="check_id()">중복체크</button></span>                    
            </li>
            <li>
                <span class="col1">비밀번호</span>
                <span class="col2"><input type="password" name="pass"></span>               
            </li>
            <li>
                <span class="col1">비밀번호 확인</span>
                <span class="col2"><input type="password" name="pass_confirm"></span>               
            </li>            
            <li>
                <span class="col1">이름</span>
                <span class="col2"><input type="text" name="name"></span>               
            </li>
            <li>
                <span class="col1">이메일</span>
                <span class="col2"><input type="text" name="email"></span>               
            </li>                        
        </ul>                       

        <ul class="buttons">
            <li><button type="button" onclick="check_input()">저장하기</button></li>
            <li><button type="button" onclick="reset_form()">지우기</button></li>
            <li><button type="button" onclick="go_back()">나가기</button></li>
        </ul>
    </form>
</body>
</html>
