<!DOCTYPE html> 
<html lang="ko"> 
<head>  
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>진단결과</title> 
    <!-- 헤더 스타일을 불러오기 -->
    <link rel="stylesheet" href="../login/css/header.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style.css">
</head> 
<body> 
    <!-- 헤더 파일을 포함 -->
    <?php 
    include "../memberboard/session.php";  // 세션 관리 포함
    include '../login/header.php';         // 헤더 파일 포함
    ?>

    <div class="content">
        <h1>진단결과</h1>

        <!-- 결과보기 버튼 -->
        <div class="text-center my-3">
            <button class="custom-btn" id="startTestBtn">결과보기</button>
        </div>

        <!-- 세부 진단 결과를 표로 표시 -->
        <h3>세부진단 결과</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>취약점 ID</th>
                    <th>심각도</th>
                    <th>설명</th>
                    <th>영향받는 시스템</th>
                    <th>해결 방법</th>
                </tr>
            </thead>
            <tbody id="resultTableBody">
                <!-- 여기서 PHP를 통해 CSV 데이터를 불러와 삽입 -->
            </tbody>
        </table>

        <!-- 심각도 분포를 나타내는 그래프 -->
        <div class="canvas-container">
            <canvas id="severityChart"></canvas>
        </div>

        <!-- 그래프 변경 버튼을 그래프 밑으로 이동 -->
        <div class="text-center my-3">
            <button class="custom-btn" id="changeGraphBtn">막대 그래프로 변경</button>
        </div>
    </div>

    <!-- Chart.js 라이브러리를 이용한 그래프 생성 -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartType = 'pie'; // 기본 그래프 타입은 원형 그래프
        let severityChart; // 차트 변수

        // 심각도에 따른 글씨 색상 설정 함수
        function getSeverityColor(severity) {
            switch(severity) {
                case 'Critical':
                    return 'red'; // Critical: 빨간색
                case 'High':
                    return 'orange'; // High: 주황색
                case 'Medium':
                    return 'yellow'; // Medium: 노란색
                case 'Low':
                    return 'green'; // Low: 초록색
                default:
                    return 'black'; // 기본 글씨 색상: 검정색
            }
        }

        // 그래프를 그리는 함수
        function drawChart(chartData, type = 'pie') {
            const ctx = document.getElementById('severityChart').getContext('2d');
            if (severityChart) severityChart.destroy(); // 기존 차트 삭제
            severityChart = new Chart(ctx, {
                type: type, // 전달받은 타입으로 그래프 그리기
                data: {
                    labels: ['Critical', 'High', 'Medium', 'Low'],
                    datasets: [{
                        label: '심각도 분포',
                        data: chartData, // 데이터가 여기에 들어감
                        backgroundColor: ['red', 'orange', 'yellow', 'green'],
                    }]
                }
            });
        }

        // '진단하기' 버튼 클릭 이벤트
        document.getElementById('startTestBtn').addEventListener('click', function() {
            // Ajax 요청을 통해 read_csv.php로 CSV 데이터를 요청
            fetch('read_csv.php')
                .then(response => {
                    console.log('응답 수신됨:', response); // 응답이 정상적으로 수신되는지 확인
                    return response.json();
                })
                .then(data => {
                    console.log('수신된 데이터:', data); // 데이터를 제대로 받았는지 확인
                    if (data.results) {
                        // 표 데이터 업데이트
                        const resultTableBody = document.getElementById('resultTableBody');
                        resultTableBody.innerHTML = ''; // 기존 데이터 지우기
                        data.results.forEach(row => {
                            const tr = document.createElement('tr');
                            row.forEach((cell, index) => {
                                const td = document.createElement('td');
                                td.textContent = cell;
                                // 심각도 열의 색상을 동적으로 적용 (두 번째 열이 심각도)
                                if (index === 1) {
                                    td.style.color = getSeverityColor(cell); // 심각도에 따라 글씨 색상 설정
                                }
                                tr.appendChild(td);
                            });
                            resultTableBody.appendChild(tr);
                        });

                        // 그래프 데이터 업데이트 (기본 타입은 'pie')
                        drawChart(data.chartData, chartType);
                    } else {
                        console.error('results 데이터가 없음:', data);
                    }
                })
                .catch(error => console.error('Error fetching CSV data:', error));
        });

        // 그래프 타입 변경 버튼 클릭 이벤트
        document.getElementById('changeGraphBtn').addEventListener('click', function() {
            // 그래프 타입을 'pie'에서 'bar'로, 또는 'bar'에서 'pie'로 변경
            chartType = (chartType === 'pie') ? 'bar' : 'pie';
            drawChart(severityChart.data.datasets[0].data, chartType);

            // 버튼 텍스트 변경
            this.textContent = (chartType === 'pie') ? '막대 그래프로 변경' : '원형 그래프로 변경';
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html>
