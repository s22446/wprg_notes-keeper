<?php

namespace App\Controller;

class NotesController extends AppController {
    public function index() {
        $userColumnsModel = $this->getTableLocator()->get('UserColumns');

        $userId = $this->request->getAttribute('identity')['id'];

        $userColumns = $userColumnsModel->find()
        ->where(['user_id' => $userId])
        ->toArray();

        foreach ($userColumns as $userColumn) {
            $notes = $this->Notes->find()
            ->where(['user_id' => $userId, 'user_column_id' => $userColumn['id']])
            ->toArray();
            
            $userColumn['notes'] = $notes;
        }

        $this->set('userColumns', $userColumns);
        $this->set('title', 'Notes Keeper');
    }

    public function addNote() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $note = $this->Notes->newEmptyEntity();

            $userId = $this->request->getAttribute('identity')['id'];
            $data = $this->request->getData();

            $note->user_id = $userId;
            $note->user_column_id = $data['columnId'];
            $note->position = $data['notePosition'];
            $note->text = "";

            if ($this->Notes->save($note)) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully added note.', 'noteId' => $note->id]));
            }
            else {
                die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during adding the note.']));
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }
}
