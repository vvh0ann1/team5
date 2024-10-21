<?php
header('Content-Type: application/json');

// CSV 파일 경로 설정 (서버의 CSV 파일 경로를 지정)
$csvDir = './csv/'; // CSV 파일이 저장된 경로
$csvFiles = glob($csvDir . '*.csv'); // 해당 디렉토리에서 CSV 파일 목록 가져오기

if (count($csvFiles) > 0) {
    $csvFile = $csvFiles[0]; // 첫 번째 CSV 파일 선택

    // CSV 파일을 읽기 위한 배열 초기화
    $results = [];
    $chartData = ['Critical' => 0, 'High' => 0, 'Medium' => 0, 'Low' => 0];

    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        // 첫 줄(헤더) 건너뛰기
        fgetcsv($handle);

        // 나머지 줄 읽기
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $results[] = $data;

            // 심각도 분포 카운팅 (그래프용 데이터)
            $severity = $data[1]; // 심각도는 두 번째 열
            if (isset($chartData[$severity])) {
                $chartData[$severity]++;
            }
        }
        fclose($handle);
    }

    // JSON 데이터 반환
    echo json_encode([
        'results' => $results,
        'chartData' => array_values($chartData) // Critical, High, Medium, Low 순서로 반환
    ]);
} else {
    echo json_encode(['error' => 'CSV 파일이 존재하지 않습니다.']);
}
