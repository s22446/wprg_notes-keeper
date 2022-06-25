<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class NotesTable extends Table {
    public function initialize(array $config): void {
        $this->addBehavior('Timestamp');
    }

    public function createNote($data, $userId) {
        $note = $this->newEmptyEntity();

        $note->user_id = $userId;
        $note->user_column_id = $data['columnId'];
        $note->position = $data['notePosition'];
        $note->text = "";

        return [
            'result' => $this->save($note),
            'noteId' => $note->id
        ];
    }

    public function updateNote($data, $userId) {
        $note = $this->get($data['noteId']);

        $note->text = $data['text'];

        $result = false;

        if ($note->user_id != $userId) {
            $errorCause = 'PERMISSIONS';
        }
        else if ($this->save($note)) {
            $result = true;
            $errorCause = '';
        }
        else {
            $errorCause = 'OTHER';
        }
        
        return [
            'result' => $result,
            'errorCause' => $errorCause
        ];
    }

    public function removeNote($data, $userId) {
        $note = $this->get($data['noteId']);

        $result = false;

        if ($note->user_id != $userId) {
            $errorCause = 'PERMISSIONS';
        }
        else if ($this->delete($note)) {
            $result = true;
            $errorCause = '';
        }
        else {
            $errorCause = 'OTHER';
        }
        
        return [
            'result' => $result,
            'errorCause' => $errorCause
        ];
    }
}
