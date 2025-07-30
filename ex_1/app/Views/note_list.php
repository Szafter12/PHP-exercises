<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Note List</title>
</head>

<body>
    <h1>Notes</h1>
    <table>
        <thead>
            <tr>
                <td>Title</td>
                <td>Created at</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notes as $note): ?>
                <tr>
                    <td>
                        <a href="/note/<?= $note['id'] ?>">
                            <?= htmlspecialchars($note['title']) ?>
                        </a>
                    </td>
                    <td>
                        <?= self::formatDate($note['created_at']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>