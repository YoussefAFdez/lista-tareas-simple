<?php

namespace App\Controller;

use App\Entity\Tarea;
use App\Repository\TareaRepository;
use App\Service\TareaManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TareaController extends AbstractController
{
    /**
     * @Route("/", name="app_listado_tarea")
     */
    public function listado(TareaRepository $tareaRepository): Response
    {
        $tareas = $tareaRepository->findAll();
        return $this->render('tarea/listado.html.twig', [
            'tareas' => $tareas,
        ]);
    }

    /**
     * @Route("/tarea/crear", name="app_crear_tarea")
     */
    public function crear(Request $request, TareaManager $tareaManager): Response
    {
        $tarea = new Tarea();
        $descripcion = $request->request->get('descripcion', null);
        if ($descripcion !== null) {
            $tarea->setDescripcion($descripcion);
            $errores = $tareaManager->validar($tarea);
            if (empty($errores)) {
                $this->addFlash('success', 'Tarea creada correctamente!');
                $tareaManager->crear($tarea);
                return $this->redirectToRoute('app_listado_tarea');
            } else {
                foreach($errores as $tipo => $error) {
                    $this->addFlash('warning', $error->getMessage());
                }
            }
        }
        return $this->render('tarea/crear.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/tarea/editar/{id}", name="app_editar_tarea")
     */
    public function editar(Tarea $tarea, Request $request, EntityManagerInterface $entityManager, TareaRepository $tareaRepository): Response
    {
        $descripcion = $request->request->get('descripcion', null);
        if ($tarea === null) {
            throw $this->createNotFoundException();
        }
        if ($descripcion !== null) {
            if (!empty($descripcion)) {
                $tarea->setDescripcion($descripcion);
                $entityManager->flush();
                $this->addFlash('success', 'Tarea editada correctamente!');
                return $this->redirectToRoute('app_listado_tarea');
            } else {
                $this->addFlash('warning', 'El campo descripción es obligatorio');
            }
        }
        return $this->render('tarea/editar.html.twig', [
            'tarea' => $tarea,
        ]);
    }

    /**
     * @Route("/tarea/eliminar/{id}", name="app_eliminar_tarea")
     */
    public function eliminar(Tarea $tarea, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($tarea);
        $entityManager->flush();
        $this->addFlash('success', 'Tarea eliminada con éxito!');
        return $this->redirectToRoute('app_listado_tarea');
    }
}
