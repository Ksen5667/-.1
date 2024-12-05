<?php

// Функция для проверки условия
function checkWordsCondition($arr) {
    // Проходим по массиву, начиная с 1-го элемента (индекс 1)
    for ($i = 1; $i < count($arr); $i++) {
        // Проверяем, что первая буква текущего слова равна последней букве предыдущего слова
        if (mb_strtolower(mb_substr($arr[$i], 0, 1)) !== mb_strtolower(mb_substr($arr[$i-1], -1))) {
            return false; // Если условие не выполняется, возвращаем false
        }
    }
    return true; // Если условие выполняется для всех пар, возвращаем true
}

// Пример массива слов
$words = ["apple", "elephant", "tiger", "rabbit"];

// Проверяем массив
if (checkWordsCondition($words)) {
    echo "Условие выполняется.\n";
} else {
    echo "Условие не выполняется.\n";
}

?>
