<?php

class NoteController
{
    public function index()
    {
        $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);

        include_once __DIR__ . '/../Views/note_list.php';
    }

    public function show($params)
    {
        $note_id = (int)$params['id'];
        $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);
        $note = null;

        foreach ($notes as $el) {
            if ($el['id'] === $note_id) {
                $note = $el;
                break;
            }
        }

        include_once __DIR__ . '/../Views/note.php';
    }

    public static function formatDate($timestamp)
    {
        $date = new DateTime($timestamp);
        $date = date_format($date, 'd-m-Y');

        return $date;
    }
}
