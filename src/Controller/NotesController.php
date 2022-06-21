<?php

namespace App\Controller;

class NotesController extends AppController {
    public function index() {
        $userColumnsModel = $this->getTableLocator()->get('UserColumns');

        $userId = $this->request->getAttribute('identity')['id'];

        $userColumns = $userColumnsModel->find()
        ->where(['user_id' => $userId])
        ->toArray();

        $notes = $this->Notes->find()
        ->where(['user_id' => $userId])
        ->toArray();

        $this->set('userColumns', $userColumns);
        $this->set('notes', $notes);
        $this->set('title', 'Notes Keeper');
    }
}
