<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EstadisticaRepository;
use App\Repository\SocioRepository;
use App\Entity\Estadistica;
use DateTime;

class EstadisticaController extends AbstractController
{
    
    private $estadisticaRepository;
    private $socioRepository;
    
    function __construct(EstadisticaRepository $estadisticaRepository, SocioRepository $socioRepository) {
        $this->estadisticaRepository = $estadisticaRepository;
        $this->socioRepository = $socioRepository;
    }
    
      /**
     * @Route("/estadistica/{id}", name="estadisticas_socio", methods={"GET"})
     */
    public function estadisticas_socio(int $id): JsonResponse
    {
        $estadisticas = $this->estadisticaRepository->findBy(["socio" => $id], ["fecha" => "ASC"]);

        $data=[];
        
        if(sizeof($estadisticas)==0)
        {
            return new JsonResponse(['status' => 'No tiene estadisticas'], Response::HTTP_OK);
        }
        else 
        {
            foreach ($estadisticas as $estadistica) 
            {
                $data[] = [
                    'id' => $estadistica->getId(),
                    'peso' => $estadistica->getPeso(),
                    'altura' => $estadistica->getAltura(),
                    'imc' => $estadistica->getImc(),
                    'fecha' => $estadistica->getFecha()
                ];
            }
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }

     /**
     * @Route("/estadistica/{id}" , name="add_estadistica" , methods={"POST"})
     */
    public function add(int $id,Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        
        $peso = (float) $data["peso"];
        $altura = (float) $data["altura"];
        $imc = (float) $data["imc"];
        $fecha = new DateTime();

	$socio = $this->socioRepository->findOneBy(array("id" => $id));

        if ($socio != null) 
        {
            if (empty($peso) || empty($altura) || empty($imc)) 
            {
                return new JsonResponse(['error' => 'Todos los campos son obligatorios. Introduzca todos los campos'], Response::HTTP_PARTIAL_CONTENT);
            } 
            else 
            {
                $estadistica = new Estadistica();

                $estadistica->setPeso($peso);
                $estadistica->setAltura($altura);
                $estadistica->setImc($imc);
                $estadistica->setFecha($fecha);
                $estadistica->setSocio($socio);

                $this->estadisticaRepository->saveEstadistica($estadistica);

                return new JsonResponse(['status' => 'Se ha registrado correctamente'], Response::HTTP_OK);
            }
        } 
        else {
            return new JsonResponse(['error' => 'No existe ningún socio con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
    }
    
    /**
     * @Route("estadistica/{id}", name="delete_estadistica", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $estadistica = $this->estadisticaRepository->findOneBy(['id' => $id]);
        
        if($estadistica == null)
        {
             return new JsonResponse(['error' => 'No existe ninguna estadistica con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
        else{
           $this->estadisticaRepository->removeEstadistica($estadistica);    
        }
        
        return new JsonResponse(['status' => 'Se ha borrado correctamente'], Response::HTTP_OK);
    }
}
