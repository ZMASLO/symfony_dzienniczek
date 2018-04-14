<?php
/**
 * Created by PhpStorm.
 * User: zmaslo
 * Date: 14.04.18
 * Time: 13:00
 */

namespace App\Entity;


class AddUser
{
    protected $name;
    protected $secondname;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSecondname()
    {
        return $this->secondname;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param mixed $secondname
     */
    public function setSecondname($secondname): void
    {
        $this->secondname = $secondname;
    }
}