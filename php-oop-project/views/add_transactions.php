<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p>
                    <?= htmlspecialchars($error) ?> 
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h1>Add Transaction</h1>
    <form action="/add_transaction" method="POST" enctype="multipart/form-data">
        <label for="csv_transaction">Select a csv file</label>
        <input type="file" name="csv_transaction[]" id="csv_transaction" accept=".csv" multiple>
        <button type="submit">Add Transaction</button>
</body>
</html>