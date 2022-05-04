<?php

namespace App\Service;

use App\Entity\Tarea;
use App\Repository\TareaRepository;
use Doctrine\ORM\EntityManagerInterface;

class TareaManager
{
    private $entityManager;
    private $tareaRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TareaRepository $tareaRepository
    ) {
        $this->entityManager = $entityManager;
        $this->tareaRepository = $tareaRepository;
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
        $errores = [];
        if (empty($tarea->getDescripcion())) {
            $errores[] = "Campo 'descripción' obligatorio";
        }
    }
}