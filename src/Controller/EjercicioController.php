<?php

namespace App\Controller;

use App\Repository\EjercicioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Ejercicio;
use App\Entity\TipoEjercicio;
use Symfony\Component\Routing\Annotation\Route;

class EjercicioController extends AbstractController
{
    private $ejercicioRepository;

    public function __construct(EjercicioRepository $ejercicioRepository)
    {
        $this->ejercicioRepository = $ejercicioRepository;
    }

    /**
      * @Route("/ejercicio", name="ejercicio" , methods={"GET"})
     */
    public function ejercicio(): JsonResponse
    {
        $ejercicios = $this->ejercicioRepository->findAll();

        $data=[];
        foreach($ejercicios as $ejer){
            $data[] = [
                'id' => $ejer->getId(),
                'nombre'=>$ejer->getNombre(),
                'ejecucion'=>$ejer->getEjecucion(),
                'foto'=>$ejer->getFoto(),
                'tipo_ejercicio_id' => $ejer->getTipoEjercicio()->getId(),
                'tipo' => $ejer->getTipoEjercicio()->getTipo()
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

    /**
     * @Route("/ejercicio/{id}", name="ejercicio_tipo" , methods={"GET"})
     */

    public function ejercicios_tipo(TipoEjercicio $tipo): JsonResponse {
        $ejercicios = $tipo->getEjercicios();
        $data=[];
        foreach($ejercicios as $ejer){
            $data[] = [
                'id' => $ejer->getId(),
                'nombre'=>$ejer->getNombre(),
                'ejecucion'=>$ejer->getEjecucion(),
                'foto'=>$ejer->getFoto(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
}
