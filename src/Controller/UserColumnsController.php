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
                die(json_encode(['status' => 'SUCCESS', 'message' => 'Successfully added column.']));
            }
            else {
                die(json_encode(['status' => 'ERROR', 'message' => 'Error during adding column.']));
            }
        }
        else {
            die(json_encode(['status' => 'ERROR', 'message' => 'Invalid request']));
        }
    }
}
