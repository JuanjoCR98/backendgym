<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rutina;
use App\Entity\Socio;
use App\Repository\RutinaRepository;
use App\Repository\SocioRepository;
use DateTime;

class RutinaController extends AbstractController
{
    
    private $rutinaRepository;
    private $socioRepository;
    
    function __construct(RutinaRepository $rutinaRepository, SocioRepository $socioRepository) {
        $this->rutinaRepository = $rutinaRepository;
        $this->socioRepository = $socioRepository;
    }

    /**
     * @Route( "/rutina" , name="getall_rutina", methods={"GET"})
     */
    public function obtenerRutinas():JsonResponse
    {
        $rutinas = $this->rutinaRepository->findAll();

        $data = [];

        foreach ($rutinas as $rutina) {
            $data[] = [
                'id' => $rutina->getId(),
                'nombre' => $rutina->getNombre(),
                'fecha_creacion' => $rutina->getFechaCreacion(),
                'usuario' => $rutina->getSocio()->getNombre() . " " . $rutina->getSocio()->getApellidos()
            ];
        }
        
        if(sizeof($data) == 0)
        {
            return new JsonResponse(["status"=>"No hay ninguna rutina"], Response::HTTP_PARTIAL_CONTENT);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    

    /**
     * @Route("/rutina/socio/{id}", name="rutina_socio", methods={"GET"})
     */
    public function rutinas_socio(Socio $socio): Response
    {
        $rutinas  = $socio->getRutinas();

        $data=[];
        
        foreach($rutinas as $rutina){
            $data[] = [
                'id' => $rutina->getId(),
                'nombre'=>$rutina->getNombre(),
                'fecha_creacion'=>$rutina->getFechaCreacion(),
            ];
        }
        return new JsonResponse($data,Response::HTTP_OK);
    }
    
    
    /**
     * @Route("/rutina/{id}" , name="add_rutina" , methods={"POST"})
     */
    public function add(int $id,Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $nombre = $data["nombre"];
        $fecha_creacion = new DateTime();

	$socio = $this->socioRepository->findOneBy(array("id" => $id));

        if ($socio != null) 
        {
            if (empty($nombre) || empty($fecha_creacion)) 
            {
                return new JsonResponse(['error' => 'Todos los campos son obligatorios. Introduzca todos los campos'], Response::HTTP_PARTIAL_CONTENT);
            } 
            else 
            {
                $rutina = new Rutina();

                $rutina->setNombre($nombre);
                $rutina->setFechaCreacion($fecha_creacion);
                $rutina->setSocio($socio);

                $this->rutinaRepository->saveRutina($rutina);

                return new JsonResponse(['status' => 'Se ha registrado correctamente'], Response::HTTP_OK);
            }
        } 
        else {
            return new JsonResponse(['error' => 'No existe ningún socio con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
    }
    
    /**
     * @Route("/rutina/{id}" , name="update_rutina" , methods={"PUT"})
     */
    public function modificar(int $id, Request $request): JsonResponse 
    {
        $rutina = $this->rutinaRepository->findOneBy(["id" => $id]);
        $data = json_decode($request->getContent(), true);

        if($rutina == null)
        {
            return new JsonResponse(["error"=>"No hay ninguna rutina con ese id"], Response::HTTP_PARTIAL_CONTENT);
        }
        else
        {
            empty($data["nombre"]) ? true : $rutina->setNombre($data["nombre"]);

            $this->rutinaRepository->updateRutina($rutina);
        }
        return new JsonResponse(['status' => 'Se ha actualizado correctamente'], Response::HTTP_OK);
    }

    /**
     * @Route("rutina/{id}", name="delete_rutina", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $rutina = $this->rutinaRepository->findOneBy(['id' => $id]);
        
        if($rutina == null)
        {
            return new JsonResponse(["error"=>"No hay ninguna rutina con ese id"], Response::HTTP_PARTIAL_CONTENT);
        }
        else{
           $this->rutinaRepository->removeRutina($rutina); 
        }
        
        return new JsonResponse(['status' => 'Se ha borrado correctamente'], Response::HTTP_OK);
    }
}
