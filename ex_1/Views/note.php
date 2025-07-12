<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $note['title'] ?></title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td>Title</td>
                <td>Content</td>
                <td>Created at</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?= htmlspecialchars($note['title']) ?>
                </td>
                <td>
                    <?= htmlspecialchars($note['description']) ?>
                </td>
                <td>
                    <?= self::formatDate($note['created_at']) ?>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
    if ($note['attachment'] != null) {
        echo "<img src='../uploads/{$note['attachment']}' />";
    }
    ?>
</body>

</html>