<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PresenceRepository")
 */
class Presence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $status;

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="presence")
     * @ORM\JoinColumn(nullable=true)
     */
    private $student;

    public function getStudent(): Student{
        return $this->student;
    }

    public function setStudent(Student $student){
        $this->student=$student;
    }

    public function getId()
    {
        return $this->id;
    }
}
