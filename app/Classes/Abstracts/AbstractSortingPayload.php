<?php

namespace App\Classes\Abstracts;
use App\Classes\Interfaces\ISortingPayload;

class AbstractSortingPayload implements ISortingPayload
{
    private $id;
    public array $ids;

    public function getId()
    {
        $this->setId();
        return $this->id;
    }

    public function setId()
    {
        $properties = get_object_vars($this);
        unset($properties['ids']);
        unset($properties['id']);
        if (isset($properties['user'])) {
            unset($properties['user']);
        }
        $this->id = md5(serialize($properties));
    }
}
