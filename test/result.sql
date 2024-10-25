CREATE TABLE security_results (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- 자동 증가하는 기본 키
    diagnostic_item VARCHAR(255) NOT NULL,  -- 진단 항목
    `system` VARCHAR(255) NOT NULL,  -- 영향받는 시스템 (예약어를 백틱으로 감쌈)
    vulnerability_status VARCHAR(20) NOT NULL,  -- 취약 여부
    solution TEXT NOT NULL,  -- 해결 방법
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- 생성 일시
    user_id INT NOT NULL  -- 사용자의 ID (참조 키)
);
