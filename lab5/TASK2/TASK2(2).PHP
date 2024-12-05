<?php

// Функция, которая проверяет, образуют ли цифры числа возрастающую арифметическую прогрессию
function isIncreasingArithmeticProgression($num) {
    // Берем целую часть числа
    $integerPart = (int)$num;
    // Получаем массив цифр целой части числа
    $digits = str_split(abs($integerPart)); // abs чтобы работать с положительными значениями
    
    // Если цифр меньше 2, то прогрессии не может быть
    if (count($digits) < 2) {
        return false;
    }

    // Проверяем разность между последовательными цифрами
    $difference = $digits[1] - $digits[0];
    
    for ($i = 1; $i < count($digits) - 1; $i++) {
        if ($digits[$i + 1] - $digits[$i] != $difference) {
            return false; // Если разность не совпадает, то не прогрессия
        }
    }

    // Если все разности совпали, то это возрастающая арифметическая прогрессия
    return true;
}

// Функция для удаления элементов из массива, удовлетворяющих условию
function removeElementsWithIncreasingProgression(&$arr) {
    // Фильтруем массив, оставляя только те элементы, которые не удовлетворяют условию
    $arr = array_filter($arr, function($value) {
        return !isIncreasingArithmeticProgression($value);
    });

    // Пересоздаем индексы массива
    $arr = array_values($arr);
}

// Пример массива
$arr = [123, 135, 456, 321, 111, 234];

// Удаляем элементы, модуль целой части которых образует возрастающую арифметическую прогрессию
removeElementsWithIncreasingProgression($arr);

// Выводим результат
echo "Массив после удаления элементов: ";
print_r($arr);

?>
