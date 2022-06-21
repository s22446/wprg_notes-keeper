<?php

namespace App\Controller;

class NotesController extends AppController {
    public function index() {
        $notes = $this->Notes->find();

        $this->set('notes', $notes);
        $this->set('title', 'Notes Keeper');
    }
}
