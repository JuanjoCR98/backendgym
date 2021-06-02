<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EjerciciosRutinaRepository;
use App\Repository\EjercicioRepository;
use App\Repository\RutinaRepository;
use App\Entity\EjerciciosRutina;

class EjerciciosRutinaController extends AbstractController
{
    private $ejerciciosRutinaRepository;
    private $ejercicioRepository;
    private $rutinaRepository;
    
    function __construct(EjerciciosRutinaRepository $ejerciciosRutinaRepository,EjercicioRepository $ejercicioRepository, RutinaRepository $rutinaRepository) {
        $this->ejerciciosRutinaRepository = $ejerciciosRutinaRepository;
        $this->ejercicioRepository = $ejercicioRepository;
        $this->rutinaRepository = $rutinaRepository;
    }

    /**
     * @Route("/ejercicios/rutina/{id}", name="ejercicios_rutinas", methods={"GET"})
     */
    
    public function ejercicios_rutina(int $id): JsonResponse
    {
        $ejercicios_rutina = $this->ejerciciosRutinaRepository->findBy(["rutina"=>$id]);
        $data = [];
        
        if($ejercicios_rutina == null)
        {
             return new JsonResponse(['status' => 'Esta rutina no tiene ejercicios'], Response::HTTP_PARTIAL_CONTENT);
        }
        else
        {
            foreach ($ejercicios_rutina as $ejer_rut)
           {   
               $data[] = [
                   'id' => $ejer_rut->getId(),
                   'tiempo' => $ejer_rut->getTiempo(),
                   'series' => $ejer_rut->getSeries(),
                   'repeticiones' => $ejer_rut->getRepeticiones(),
                   'rutina'=> $ejer_rut->getRutina()->getNombre(),
                   'ejercicio' => [
                       'id_ejercicio' => $ejer_rut->getEjercicio()->getId(),
                       'nombre' => $ejer_rut->getEjercicio()->getNombre(),
                       'ejecucion' => $ejer_rut->getEjercicio()->getEjecucion(),
                       'foto' => $ejer_rut->getEjercicio()->getFoto(),
                       'tipo' => $ejer_rut->getEjercicio()->getTipoEjercicio()->getTipo()
                   ]
               ];
           }   
        }
 
         return new JsonResponse($data,Response::HTTP_OK);  
    }
    
    /**
     * @Route("/ejercicios/rutina/{id}" , name="add_ejerciciosrutina" , methods={"POST"})
     */
    public function add(int $id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $tiempo = $data["tiempo"];
        $repeticiones = $data["repeticiones"];
        $series = $data["series"];
        $id_ejercicio = $data["ejercicio"];
        
	$ejercicio = $this->ejercicioRepository->findOneBy(array("id" => $id_ejercicio));
        $rutina = $this->rutinaRepository->findOneBy(array("id" => $id));
        
        if ($rutina != null) 
        {
            if (empty($ejercicio)) 
            {
                return new JsonResponse(['error' => 'Introduzca un ejercicio. Campo obligatorio'], Response::HTTP_PARTIAL_CONTENT);
            } 
            else 
            {
                $ejercicio_rutina = new EjerciciosRutina();

                $ejercicio_rutina->setTiempo($tiempo);
                $ejercicio_rutina->setRepeticiones($repeticiones);
                $ejercicio_rutina->setSeries($series);
                $ejercicio_rutina->setEjercicio($ejercicio);
                $ejercicio_rutina->setRutina($rutina);

                $this->ejerciciosRutinaRepository->saveEjercicioRutina($ejercicio_rutina);

                return new JsonResponse(['status' => 'Se ha insertado correctamente'], Response::HTTP_OK);
            }
        } 
        else {
            return new JsonResponse(['error' => 'No existe ninguna rutina con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
    }
    
     /**
     * @Route("/ejercicios/rutina/{id}", name="delete_ejerciciorutina", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $ejer_rutina = $this->ejerciciosRutinaRepository->findOneBy(['id' => $id]);
        
        if($ejer_rutina == null)
        {
            return new JsonResponse(["error"=>"No existe"], Response::HTTP_PARTIAL_CONTENT);
        }
        else{
           $this->ejerciciosRutinaRepository->removeEjercicioRutina($ejer_rutina); 
        }
        
        return new JsonResponse(['status' => 'Se ha borrado correctamente'], Response::HTTP_OK);
    }
}
