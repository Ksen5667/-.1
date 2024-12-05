
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Таблица умножения</title>
   <link rel="stylesheet" href = "style1.css">
</head>
<body>
    <h1 style="text-align: center;">Таблица умножения</h1>
    <table>
        <thead>
            <tr>
                <th>*</th>
                <?php for ($i = 0; $i <= 10; $i++): ?>
                    <th><?= $i ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i <= 10; $i++): ?>
                <tr>
                    <th><?= $i ?></th>
                    <?php for ($j = 0; $j <= 10; $j++): ?>
                        <td><?= $i * $j ?></td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</body>
</html>
