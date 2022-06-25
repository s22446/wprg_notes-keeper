<?php

namespace App\Controller;

class UserColumnsController extends AppController {
    public function addColumn() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $userColumn = $this->UserColumns->newEmptyEntity();

            $userId = $this->request->getAttribute('identity')['id'];
            $data = $this->request->getData();

            $userColumn->user_id = $userId;
            $userColumn->name = $data['columnName'];
            $userColumn->position = $data['columnPosition'];

            if ($this->UserColumns->save($userColumn)) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully added column.', 'columnId' => $userColumn->id]));
            }
            else {
                die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during adding the column.']));
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }

    public function removeColumn() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $data = $this->request->getData();
            $columnId = $data['columnId'];

            $column = $this->UserColumns->get($columnId);
            
            if ($this->UserColumns->delete($column)) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully removed column.']));
            }
            else {
                die(json_encode(['status' => 'ERROR', 'message' => 'Error occured during deletion of the column.']));
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }
}
