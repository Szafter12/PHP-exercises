<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add note</title>
</head>

<body>
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }
    }
    ?>
    <form action="/note" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="title">
        <textarea name="description"></textarea>
        <input type="file" name="attached_file">
        <button type="submit" name="save_note">Save</button>
    </form>
</body>

</html>