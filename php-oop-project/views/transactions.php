<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }

        .expense {
            color: red;
        }

        .income {
            color: green;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check #</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= htmlspecialchars(\App\Helpers::format_data($transaction['transaction_date'])) ?></td>
                    <td><?= htmlspecialchars($transaction['check_number']) ?></td>
                    <td><?= htmlspecialchars($transaction['description']) ?></td>
                    <td class="<?= $transaction['amount'] < 0 ? 'expense' : 'income' ?>">
                        <?=
                        htmlspecialchars(\App\Helpers::format_amount($transaction['amount']))
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total Income:</th>
                <td><?= htmlspecialchars(\App\Helpers::format_amount(\App\Helpers::get_total_income($transactions))) ?></td>
            </tr>
            <tr>
                <th colspan="3">Total Expense:</th>
                <td><?= htmlspecialchars(\App\Helpers::format_amount(\App\Helpers::get_total_expense($transactions))) ?></td>
            </tr>
            <tr>
                <th colspan="3">Net Total:</th>
                <td><?= htmlspecialchars(\App\Helpers::format_amount(\App\Helpers::get_net_total($transactions))) ?></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>