# 현대오토에버 SW 스쿨 : IT 보안 (5팀)
LAMP 웹 서버 취약점 점검 자동화 도구 개발

## 🖥 프로젝트 소개

## 🕰 개발 기간
24.10.15.(화) ~ 24.10.25.(금)

## 👤 멤버 구성
- 강예은: Apache 진단
- 김승주: Server(Linux) 진단
- 심민: LAMP 기반 웹 서버 구축
- 최지수: PHP 진단
- 황태윤: My-SQL 진단

## ⚙ 개발 환경
- Ansible
- Amazon Linux Servers
- Amazon Linux 2023
- Amazon Linux 2
- Ubuntu Linux
- MySql

## 📌 실행 방법
1. 기본 프로그램 설치


## 📌 주요 구현 사항
- Pre Task
  - OS 별 처리
  - Docker 확인
 
- Task
  - 진단

- Post Task
  - 결과 파일 생성 및 저장
  - 웹 페이지 호출

### Infra Architecture
![infra architecture](https://github.com/user-attachments/assets/a42a6170-16db-4644-81b4-ed6b1649472b)




## 📌 실행 화면
- Server(Linux) 진단 결과
- Apache 진단 결과
- PHP 진단 결과
- My-SQL 진단 결과



## LAMP 스택 구현
- Linux: Amazon Linux(Redhat 계열), Ubuntu
- Apache: Apache/2.4.62 
- Mysql: MySQL 8.0.40
  - Mysql 설치
    - sudo dnf install https://dev.mysql.com/get/mysql80-community-release-el8-3.noarch.rpm
    - sudo dnf install mysql-server
    - sudo systemctl start mysqld
    - sudo systemctl enable mysqld
    - sudo mysql_secure_installation


- PHP: PHP 8.3.10
  - PHP 설치  
    - sudo dnf install php php-mysqlnd php-xml php-mbstring php-zip php-fpm
    - sudo dnf install mysql-server
    - sudo systemctl start mysqld
    - sudo systemctl enable mysqld
    - sudo systemctl restart httpd


## 리눅스 파일 위치
- /var/www/html/(자신의 프로젝트)


## 프로그래밍 언어
- PHP, JavaScirpt


## 도커 설정
- 패키지 업데이트
  - sudo apt update         # Ubuntu
  - sudo yum update         # Amazon Linux, Red Hat

- 도커 설치
  - sudo apt install -y docker.io             # Ubuntu
  - sudo amazon-linux-extras install docker -y       # Amazon Linux, Red Hat

- Docker 시작 및 부팅 시 자동 실행 설정
  - sudo systemctl start docker
  - sudo systemctl enable docker

- 컨테이너 다운 및 Mysql 실행
  - docker pull mysql:latest
  - docker run --name mysql-server -e MYSQL_ROOT_PASSWORD=비밀번호 -p 3306:3306 -d mysql:latest

- 도커로 mysql 실행
  - docker exec -it mysql-server mysql -u root -p

## PHP ZipArchive 설치
- sudo dnf install php php-xml php-mbstring php-zip
## Composer를 통한 설치
- curl -sS https://getcomposer.org/installer | php
- sudo mv composer.phar /usr/local/bin/composer
- composer require phpoffice/phpword

## config.php 설정
<?php
return [    
    'DB_HOST' => ' ',                         //ip주소
    'DB_USER' => ' ',                         //id
    'DB_PASSWORD' => ' ',           //비번
    'DB_NAME' => ' ',                    //db이름
];
?>

## 방화벽 인바운드 설정
80, 443 포트 0.0.0.0
22 허용         //ssh 접속
3306 포트 허용      //DB접속

## Reference


## License
[MIT](https://choosealicense.com/licenses/mit/)
