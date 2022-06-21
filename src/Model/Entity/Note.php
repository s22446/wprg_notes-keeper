<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Note extends Entity {
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'user_id' => false,
        'user_column_id' => false,
        'position' => false,
        'text' => false
    ];
}
