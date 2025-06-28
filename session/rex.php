<?php

$text = "안녕하세요. 제 이메일 주소는 example@example.com 입니다. 궁금한 점이 있으시면 info@domain.co.kr 로 연락 주세요. test@sub.domain.net 도 있습니다.";

// 이메일 주소를 찾기 위한 정규 표현식
// 이 정규 표현식은 일반적인 이메일 주소 형식(알파벳, 숫자, .-_ + @ 알파벳, 숫자, .-)을 포함합니다.
$pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';

$matches = []; // 일치하는 이메일 주소를 저장할 배열

// preg_match_all() 함수를 사용하여 모든 일치 항목 찾기
// 첫 번째 인자는 정규 표현식, 두 번째 인자는 검색할 문자열, 세 번째 인자는 일치 결과를 저장할 배열
if (preg_match_all($pattern, $text, $matches)) {
    echo "추출된 이메일 주소:\n";
    foreach ($matches[0] as $email) {
        echo $email . "\n";
    }
} else {
    echo "문자열에서 이메일 주소를 찾을 수 없습니다.\n";
}

?>