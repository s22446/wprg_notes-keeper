<?php

namespace App\Controller;

class NotesController extends AppController {
    public function index() {
        $userColumnsModel = $this->getTableLocator()->get('UserColumns');

        $userId = $this->request->getAttribute('identity')['id'];

        $userColumnsWithNotes = $userColumnsModel->getUserColumnsWithNotes($userId);

        $this->set('userColumnsWithNotes', $userColumnsWithNotes);
        $this->set('title', 'Notes Keeper');
    }

    public function addNote() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $userId = $this->request->getAttribute('identity')['id'];
            
            $noteAddReturn = $this->Notes->createNote($this->request->getData(), $userId);

            if ($noteAddReturn['result']) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully added note.', 'noteId' => $noteAddReturn['noteId']]));
            }
            else {
                die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during adding the note.']));
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }

    public function saveNote() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $userId = $this->request->getAttribute('identity')['id'];

            $noteUpdateReturn = $this->Notes->updateNote($this->request->getData(), $userId);

            if ($noteUpdateReturn['result']) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully saved note.']));
            }
            else {
                if ($noteUpdateReturn['errorCause'] == 'PERMISSIONS') {
                    die(json_encode(['status' => 'ERROR', 'message' => 'You don\'t have permissions to manage this note.']));
                }
                else {
                    die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during saving the note.']));
                }
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }

    public function removeNote() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $userId = $this->request->getAttribute('identity')['id'];

            $noteRemoveReturn = $this->Notes->removeNote($this->request->getData(), $userId);

            if ($noteRemoveReturn['result']) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully removed note.']));
            }
            else {
                if ($noteRemoveReturn['errorCause'] === 'PERMISSIONS') {
                    die(json_encode(['status' => 'ERROR', 'message' => 'You don\'t have permissions to manage this note.']));
                }
                else {
                    die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during deletion of the note.']));
                }
            }
        }
    }

    public function exportNotes() {
        $this->autoRender = false;

        $userColumnsModel = $this->getTableLocator()->get('UserColumns');

        $userId = $this->request->getAttribute('identity')['id'];

        $userColumnsWithNotes = $userColumnsModel->getUserColumnsWithNotes($userId);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=notes-' . date("d.m.Y H:i:s") . '.csv');
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");

        $headerArray = [];
        $longestNoteColumnLength = 0;

        foreach ($userColumnsWithNotes as $userColumn) {
            $headerArray[] = $userColumn['name'];

            if (count($userColumn['notes']) > $longestNoteColumnLength) {
                $longestNoteColumnLength = count($userColumn['notes']);
            }
        }

        fputcsv($output, $headerArray, ";");

        for ($i = 0; $i < $longestNoteColumnLength; $i++) {
            $contentArray = [];
            foreach ($userColumnsWithNotes as $userColumn) {
                $contentArray[] = isset($userColumn['notes'][$i]) ? $userColumn['notes'][$i]['text'] : '';
            }

            fputcsv($output, $contentArray, ";");
        }
    }
}
