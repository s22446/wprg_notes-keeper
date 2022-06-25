<?php

namespace App\Controller;

class UserColumnsController extends AppController {
    public function addColumn() {
        $this->autoRender = false;

        if ($this->request->is('ajax')) {
            $userId = $this->request->getAttribute('identity')['id'];

            $columnAddReturn = $this->UserColumns->createColumn($this->request->getData(), $userId);

            if ($columnAddReturn['result']) {
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully added column.', 'columnId' => $columnAddReturn['columnId']]));
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

            $userId = $this->request->getAttribute('identity')['id'];

            $column = $this->UserColumns->get($columnId);

            if ($column->user_id != $userId) {
                die(json_encode(['status' => 'ERROR', 'message' => 'You don\'t have permissions to manage this column.']));
            }

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
