<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UserColumnsTable extends Table {
    public function initialize(array $config): void {
        $this->addBehavior('Timestamp');
    }
}
