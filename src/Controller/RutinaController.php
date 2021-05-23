<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Socio;
use App\Repository\RutinaRepository;

class RutinaController extends AbstractController
{
    
    private $rutinaRepository;
    
    function __construct(RutinaRepository $rutinaRepository) {
        $this->rutinaRepository = $rutinaRepository;
    }

       /**
     * @Route("/rutina/{id}", name="rutina_socio", methods={"GET"})
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
}
