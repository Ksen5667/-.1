<?php

function sumFromPositiveCosine($arr) {
    foreach ($arr as $key => $value) {
        if (cos($value) > 0) {
            $sum = 0;
            for ($i = $key; $i < count($arr); $i++) {
                $sum += $arr[$i];
            }
            return $sum; // Возвращаем сумму
        }
    }
    return 0; // Если не найдено элемента с положительным косинусом
}

// Пример использования
$arr = [1.0, -0.5, 0.0, 2.5, -3.0];
$result = sumFromPositiveCosine($arr);

echo "Сумма элементов от первого положительного косинуса до конца: " . $result . "\n";

?>


