<?php

namespace App\Controllers;

use App\Helpers;
use App\View;
use App\Models\Transactions;

class TransactionsController
{

    public function index()
    {
        $transactions = new Transactions();
        $transactions = $transactions->getAllTransactions();
        return View::make("transactions", ['transactions' => $transactions]);
    }

    public function create()
    {
        return View::make("add_transactions");
    }

    public function store()
    {

        // Helpers::dd($_FILES);

        if (!is_dir(STORAGE_PATH)) {
            mkdir(STORAGE_PATH, 0777, true);
        }

        $allowed_ext = ['csv'];
        $errors = [];

        $file = $_FILES['csv_transaction'];

        if (!$file) {
            $errors[] = 'No file uploaded';
            return View::make('add_transactions', ['errors' => $errors]);
        }

        for ($i = 0; $i < count($file['name']); $i++) {
            $file_tmp_name = $file['tmp_name'][$i];
            $file_name = $file['name'][$i];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

            if (!in_array($file_ext, $allowed_ext)) {
                $errors[] = 'File type not allowed';
                return View::make('add_transactions', ['errors' => $errors]);
            }

            $file_new_path = STORAGE_PATH . '/' . pathinfo($file_name, PATHINFO_FILENAME) . '_' . bin2hex(random_bytes(8)) . '.' . $file_ext;

            if (!move_uploaded_file($file_tmp_name, $file_new_path)) {
                $errors[] = 'Failed to move uploaded file';
                return View::make('add_transactions', ['errors' => $errors]);
            }

            $row = 1;
            if (($handle = fopen($file_new_path, "r")) !== FALSE) {

                $transaction = new Transactions();

                while (($data = fgetcsv($handle)) !== FALSE) {
                    if ($row == 1) {
                        $row++;
                        continue;
                    }

                    $transactionData = [
                        'date' => $data[0],
                        'check_number' => $data[1],
                        'description' => $data[2],
                        'amount' => $data[3]
                    ];

                    $transactionData['amount'] = str_replace('$', '', $transactionData['amount']);
                    $transactionData['date'] = date('Y-m-d', strtotime($transactionData['date']));

                    $is_check = !empty($transactionData['check_number']);

                    if (!$transaction->addTransaction($transactionData, $is_check)) {
                        $errors[] = "Some error occurred on row $row";
                    }

                    $row++;
                }
                fclose($handle);
            }
        }

        if (!empty($errors)) {
            return View::make("add_transactions", ['errors' => $errors]);
        }

        header('Location: /transactions');
        exit;
    }
}
