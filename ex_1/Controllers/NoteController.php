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

    public function store()
    {
        if (isset($_POST['save_note'])) {
            $note_id = self::getNoteId();
            $note_title = $_POST['title'] ?? null;
            $note_description = $_POST['description'] ?? null;
            $date = new DateTime();
            $created_at = $date->format('c');
            $file = $this->extractFile('attached_file');

            if (!is_array($file)) {
                return;
            }

            $file_path = null;

            if (!empty($file)) {
                $file_name = $file[0];
            }

            $new_note = [
                'id' => $note_id,
                'title' => $note_title,
                'description' => $note_description,
                'created_at' => $created_at,
                'attachment' => $file_name
            ];

            $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);

            array_push($notes, $new_note);

            if (file_put_contents(__DIR__ . '/../storage/notes.json', json_encode($notes),) != false) {
                header("Location: /");
                exit;
            }
        }
    }

    protected function extractFile($field_name)
    {
        if (isset($_FILES[$field_name]) && $_FILES[$field_name]['error'] === 0) {
            $errors = [];
            $storage_path = __DIR__ . "/../uploads/";

            if (!is_dir($storage_path)) {
                mkdir($storage_path, 0755, true);
            }

            $allowed_ext = ['jpg', 'png', 'jpeg', 'webp'];
            $max_size = 6 * 1024 * 1024;

            $filename = $_FILES[$field_name]['name'];
            $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $tmp_name = $_FILES[$field_name]['tmp_name'];

            if (in_array($file_ext, $allowed_ext)) {
                if ($_FILES[$field_name]['size'] <= $max_size) {
                    $file_new_name = bin2hex(random_bytes(8));
                    $file_full_path = $storage_path . $file_new_name . "." . $file_ext;

                    if (move_uploaded_file($tmp_name, $file_full_path)) {
                        return [$file_new_name . "." . $file_ext, $errors];
                    } else {
                        $errors[] = "Something went wrong while save file";
                    }
                } else {
                    $errors[] = "File must have less than 6MB";
                }
            } else {
                $errors[] = $file_ext . " extension is not allowed";
            }
            return include_once __DIR__ . '/../Views/add_note.php';
        }
        return [];
    }

    public function add_note()
    {
        self::getNoteId();

        return include_once __DIR__ . '/../Views/add_note.php';
    }

    public static function formatDate($timestamp)
    {
        $date = new DateTime($timestamp);
        $date = date_format($date, 'd-m-Y');

        return $date;
    }

    protected static function getNoteId()
    {
        $notes = json_decode(file_get_contents(__DIR__ . '/../storage/notes.json'), true);

        $notes_count = count($notes);
        $note_id = (int)$notes_count + 1;

        return $note_id;
    }
}
