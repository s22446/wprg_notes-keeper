<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserColumnsTable extends Table {
    public function initialize(array $config): void {
        $this->addBehavior('Timestamp');

        $this->hasMany('Notes')
        ->setForeignKey('user_column_id')
        ->setDependent(true);
    }

    public function createColumn($data, $userId) {
        $userColumn = $this->newEmptyEntity();

        $userColumn->user_id = $userId;
        $userColumn->name = $data['columnName'];
        $userColumn->position = $data['columnPosition'];

        return [
            'result' => $this->save($userColumn),
            'columnId' => $userColumn->id
        ];
    }

    public function modifyColumn($data, $userId) {
        $userColumn = $this->get($data['columnId']);

        $userColumn->name = $data['newColumnName'];

        $result = false;

        if ($userColumn->user_id != $userId) {
            $errorCause = 'PERMISSIONS';
        }
        else if ($this->save($userColumn)) {
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
