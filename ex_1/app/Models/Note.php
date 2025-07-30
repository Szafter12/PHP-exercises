<?php

namespace App\Models;

class Note {
    public static function getNoteId()
    {
        $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);

        $notes_count = count($notes);
        $note_id = (int)$notes_count + 1;

        return $note_id;
    }

    public function save($note) {
        $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);

            array_push($notes, $note);

            if (file_put_contents(__DIR__ . '/../storage/notes.json', json_encode($notes),) != false) {
                header("Location: /");
                exit;
            }
    }

    public static function get() {
        return json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);
    }

    public static function find($id) {
        $notes = self::get();
        $note = null;
        foreach ($notes as $el) {
            if ($el['id'] === $id) {
                $note = $el;
                break;
            }
        }
        return $note;
    } 
}
