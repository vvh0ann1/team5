<?php 
    // 로그인 UI 
    session_start(); 
    if (isset($_SESSION["userid"]))  
        $userid = $_SESSION["userid"]; 
    else  
        $userid = ""; 
         
    if (isset($_SESSION["username"]))  
        $username = $_SESSION["username"]; 
    else  
        $username = ""; 
?>    
<!DOCTYPE html> 
<html lang="ko"> 
<head>  
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>오토에버 로그인</title> 
    <link rel="stylesheet" href="./css/index.css"> 
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .video-section {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .video-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* 화면을 꽉 채우되 비율 유지 */
            z-index: -1;
        }
        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            margin-top: 20px;
        }
        .header {
            background: rgba(15, 0, 114, 0.8);
            padding: 20px;
            color: white;
        }
        .top a.btn {
            margin-left: 10px;
            color: #0f0072;
            text-decoration: none;
            background-color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .top a.btn:hover {
            color: white;
            background-color: #0f0072;
            text-decoration: none;
        }
    </style>
</head> 
<body> 
    <header class="header"> 
        <div class="container">
            <h3 class="logo"> 
                <ul>
                    <span style="font-size: 20px; font-weight: bold;">HYUNDAI</span><br>
                    <span style="font-size: 20px; font-weight: bold;">Autoever 붙여조</span>
                </ul>
                <a href="index.php">홈</a>
                <a href="../memberboard/list.php" class="memberboard-btn">게시판</a>
                <a href="test.php" class="result-btn">진단결과</a>
            </h3> 
            <nav class="top">
<?php 
    if(!$userid) { 
?>                 
                <a href="form.php" class="btn">회원가입</a>
                <a href="login_form.php" class="btn">로그인</a>
<?php 
    } else { 
        $logged = $username."(".$userid.")"; 
?> 
                <span class="logged"><?=$logged?> </span>
                <a href="logout.php" class="btn">로그아웃</a>
                <a href="modify_form.php" class="btn">정보수정</a>
<?php 
    } 
?> 
            </nav> 
        </div>
    </header> 
    <div class="video-section">
        <video class="video-bg" autoplay muted loop>
            <source src="./videos/background.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</body> 
</html>
