<?php

namespace App\Models;

use App\Model;

class Transactions extends Model
{

    public function getAllTransactions()
    {
        $sql = "SELECT * FROM transactions";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $transactions = $stmt->fetchAll();

        return $transactions;
    }

    public function addTransaction($data, $is_check = false)
    {
        if ($is_check) {
            $sql = "INSERT INTO transactions (transaction_date, check_number, description, amount) VALUES (?, ?, ?, ?)";
        } else {
            $sql = "INSERT INTO transactions (transaction_date, description, amount) VALUES (?, ?, ?)";
        }

        try {
            $stmt = $this->db->prepare($sql);
            if ($is_check) {
                $stmt->execute([$data['date'], $data['check_number'], $data['description'], $data['amount']]);
            } else {
                $stmt->execute([$data['date'], $data['description'], $data['amount']]);
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}
