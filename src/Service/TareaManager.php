<?php

namespace App\Service;

use App\Entity\Tarea;
use App\Repository\TareaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TareaManager
{
    private $entityManager;
    private $tareaRepository;
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager,
        TareaRepository $tareaRepository,
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->tareaRepository = $tareaRepository;
        $this->validator = $validator;
    }

    public function crear(Tarea $tarea) : void {
        $this->entityManager->persist($tarea);
        $this->entityManager->flush();
    }

    public function guardar() : void {
        $this->entityManager->flush();
    }

    public function eliminar(Tarea $tarea) : void {
        $this->entityManager->remove($tarea);
        $this->entityManager->flush();
    }

    public function validar(Tarea $tarea) {
        $errores = $this->validator->validate($tarea);
        return $errores;
    }
}