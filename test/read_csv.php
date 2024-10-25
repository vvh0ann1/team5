<?php
header('Content-Type: application/json');
include '../memberboard/session.php';

// 세션에 userid가 설정되어 있는지 확인
if (!isset($_SESSION['userid'])) {
    echo json_encode(['error' => '로그인 후 이용해 주세요.']);
    exit; 
}

$userId = $_SESSION['userid']; // 세션에서 사용자 ID 가져오기

$csvDir = './csv/'; // CSV 파일이 저장된 경로
$csvFiles = glob($csvDir . '*.csv'); // 해당 디렉토리에서 CSV 파일 목록 가져오기

$results = []; // 모든 파일의 결과를 저장할 배열
$vulnerableCount = 0;
$secureCount = 0;

$config = require '../config.php';

$db_host = $config['DB_HOST'];
$db_user = $config['DB_USER'];
$db_password = $config['DB_PASSWORD'];
$db_name = $config['DB_NAME'];

$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (mysqli_connect_errno()) {
    echo json_encode(['error' => 'DB 연결에 실패했습니다.']);
    exit();
}

if (count($csvFiles) > 0) {
    $sql = "INSERT INTO security_results (diagnostic_item, system, vulnerability_status, solution, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['error' => 'SQL 준비 실패: ' . $con->error]);
        exit();
    }

    // CSV 파일 목록 순서대로 처리
    foreach ($csvFiles as $csvFile) {
        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            // 모든 줄 읽기
            while (($data = fgetcsv($handle)) !== FALSE) {
                // 행에서 모든 요소가 비어있는지 확인하고, 비어있는 경우 건너뛰기
                if (empty(array_filter($data, 'trim'))) {
                    continue; // 빈 행을 건너뜀
                }

                // CSV에서 데이터 추출 및 트림
                $system = trim($data[0], "\"'");
                $diagnostic_item = trim($data[1], "\"'");
                $vulnerabilityStatus = strtoupper(trim($data[2], "\"'")); // Trim and ensure uppercase 'S' or 'V'
                $solution = trim($data[3], "\"'");

                // 취약 여부 카운팅
                if ($vulnerabilityStatus === 'V') {
                    $vulnerableCount++;
                } elseif ($vulnerabilityStatus === 'S') {
                    $secureCount++;
                }

                // DB에 삽입 (user_id 추가)
                $stmt->bind_param("sssss", $diagnostic_item, $system, $vulnerabilityStatus, $solution, $userId);
                $stmt->execute();

                // 결과 배열에 추가
                $results[] = [
                    'system' => $system,
                    'diagnostic_item' => $diagnostic_item,
                    'vulnerability_status' => $vulnerabilityStatus,
                    'solution' => $solution
                ];
            }
            fclose($handle);
        }
    }

    // 결과를 JSON으로 반환
    echo json_encode([
        'results' => $results,
        'chartData' => [$secureCount, $vulnerableCount] // 안전, 취약 순서로 반환
    ]);

    // 자원 해제
    $stmt->close();
} else {
    echo json_encode(['error' => 'CSV 파일이 존재하지 않습니다.']);
}

$con->close(); // DB 연결 종료
?>
