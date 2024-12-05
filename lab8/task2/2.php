<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь</title>
 <link rel="stylesheet" href = "style2.css">
   
</head>
<body>
    <?php
    function generateCalendar($month = null, $year = null, $holidays = []) {
        
        $month = $month ?? date('n'); // 
        $year = $year ?? date('Y');  // 

        
        $weekDays = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $monthNames = [
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
        ];

        
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

       
        $firstDayOfMonth = date('N', strtotime("$year-$month-01"));

       
        echo "<h2>{$monthNames[$month]} $year</h2>";

        
        echo "<table>";
        echo "<tr>";

       
        foreach ($weekDays as $day) {
            echo "<th>$day</th>";
        }
        echo "</tr><tr>";

        
        for ($i = 1; $i < $firstDayOfMonth; $i++) {
            echo "<td></td>";
        }

       
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = sprintf("%02d-%02d", $month, $day); // Формат MM-DD
            $dayOfWeek = date('N', strtotime("$year-$month-$day"));

           
            $class = '';
            if ($dayOfWeek == 6 || $dayOfWeek == 7) { 
                $class = 'weekend';
            }
            if (in_array($currentDate, $holidays)) { 
                $class = 'holiday';
            }

            echo "<td class='$class'>$day</td>";

          
            if ($dayOfWeek == 7 && $day != $daysInMonth) {
                echo "</tr><tr>";
            }
        }

       
        $lastDayOfMonth = date('N', strtotime("$year-$month-$daysInMonth"));
        for ($i = $lastDayOfMonth + 1; $i <= 7; $i++) {
            echo "<td></td>";
        }

        echo "</tr></table>";
    }

   
    $holidays = [
        '01-01', '01-07', 
        '03-08', '02-23', 
        '05-09', '05-01', 
        '12-31', '06-12', '11-04'
    ];

   
    generateCalendar(null, null, $holidays);

   
    echo "<hr>";
    generateCalendar(05, 2023, $holidays);
    ?>
</body>
</html>
