<?php
// function divide($diviend, $divisor) {
//     if($divisor == 0) {
//         throw new Exception("Divison by zero");
//     }
//     return $diviend / $divisor;
// }

// try {
//     echo divide(5, 2);
// } catch (Exception $e) {
//     echo "Unable to divide";
// } finally {
//     echo '<BR>프로그램 종료';
// }

try {
    $filename = 'data.txt';
    if(!file_exists($filename)) {
        throw new Exception('파일이 존재하지 않습니다.');
    }
    $content = file_get_contents($filename);
    echo $content;
} catch (Exception $e) {
    echo "오류 : ". $e->getMessage();
}
