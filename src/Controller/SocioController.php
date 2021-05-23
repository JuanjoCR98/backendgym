<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Socio;
use App\Repository\SocioRepository;
use DateTime;

class SocioController extends AbstractController
{
    private $socioRepository;
    
    function __construct(SocioRepository $socioRepository) {
        $this->socioRepository = $socioRepository;
    }

    /**
     * @Route( "/socio/{id}" , name="get_socio", methods={"GET"})
     */
    public function obtener(int $id)
    {
        $socio = $this->socioRepository->findOneBy(["id" => $id]);
        
        if($socio == null)
        {
             return new JsonResponse(['error' => 'No existe ningún socio con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
        
        $data = [
            "id" => $socio->getId(),
            "nombre" => $socio->getNombre(),
            "apellidos" => $socio->getApellidos(),
            "fecha_nacimiento" => $socio->getFechaNacimiento(),
            "email" => $socio->getEmail(),
            "password" => $socio->getPassword()
        ];
        
        return new JsonResponse($data, Response::HTTP_OK);
    }
    
     /**
     * @Route( "/socio" , name="getall_socio", methods={"GET"})
     */
    public function obtenerTodos()
    {
        $socio = $this->socioRepository->findAll();
        
        $data = [];
        foreach($socio as $socio)
        {
             $data[] = [
                "id" => $socio->getId(),
                "nombre" => $socio->getNombre(),
                "apellidos" => $socio->getApellidos(),
                "fecha_nacimiento" => $socio->getFechaNacimiento(),
                "email" => $socio->getEmail(),
                "password" => $socio->getPassword()
            ];
        }
        
        return new JsonResponse($data, Response::HTTP_OK);
    }
    
    /**
     * @Route("/socio" , name="add_socio" , methods={"POST"})
     */
    public function add(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        
        $nombre = $data["nombre"];
        $apellidos = $data["apellidos"];
        $fecha_nacimiento = $data["fecha_nacimiento"];
        $email = $data["email"];
        $password = $data["password"];
        
        $existe_usuario = $this->socioRepository->findOneBy(array("email" => $email));
        
       if($existe_usuario == null)
        {
            if( empty($nombre) || empty($apellidos) || empty($fecha_nacimiento) || empty($email) || empty($password))
            {
                return new JsonResponse(['error' => 'Todos los campos son obligatorios. Introduzca todos los campos'], Response::HTTP_PARTIAL_CONTENT);
            }
            else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                 return new JsonResponse(['error' => 'Introduzca un email válido'], Response::HTTP_PARTIAL_CONTENT);
            }
            else if(strlen($password)<4)
            {
                 return new JsonResponse(['error' => 'La contraseña debe de tener al menos 4 caracteres'], Response::HTTP_PARTIAL_CONTENT);
            }
            else
            {
                $socio = new Socio();
        
                $socio->setNombre($nombre);
                $socio->setApellidos($apellidos);
                $date = new DateTime($fecha_nacimiento);
                $socio->setFechaNacimiento($date);
                $socio->setEmail($email);
                $socio->setPassword(password_hash($password, PASSWORD_BCRYPT));
                
                $this->socioRepository->saveSocio($socio);
                
                return new JsonResponse(['status' => 'Se ha registrado correctamente'], Response::HTTP_OK);
            }   
        }
        else
        {
            return new JsonResponse(['error' => 'Ya existe un socio con ese email'], Response::HTTP_PARTIAL_CONTENT);
        }      
    }
    
    /**
     * @Route("/socio/{id}" , name="update_socio" , methods={"PUT"})
     */
    public function modificar(int $id, Request $request): JsonResponse
    {
        $socio = $this->socioRepository->findOneBy(["id" => $id]);
        $data = json_decode($request->getContent(),true);
        
        $date = new DateTime($data["fecha_nacimiento"]);
         
         $existe_usuario = $this->socioRepository->findOneBy(array("email" => $data["email"]));
         
         if (($socio->getEmail() == $data["email"]) || $existe_usuario == null) 
         {
            if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) 
            {
                return new JsonResponse(['error' => 'Introduzca un email válido'], Response::HTTP_PARTIAL_CONTENT);
            } 
            else if (strlen($data["password"]) < 4) 
            {
                return new JsonResponse(['error' => 'La contraseña debe de tener al menos 4 caracteres'], Response::HTTP_PARTIAL_CONTENT);
            } 
            else 
            {
                empty($data["nombre"]) ? true : $socio->setNombre($data["nombre"]);
                empty($data["apellidos"]) ? true : $socio->setApellidos($data["apellidos"]);
                empty($data["fecha_nacimiento"]) ? true : $socio->setFechaNacimiento($date);
                empty($data["email"]) ? true : $socio->setEmail($data["email"]);
                empty($data["password"]) ? true : $socio->setPassword(password_hash($data["password"], PASSWORD_BCRYPT));

                $this->socioRepository->updateSocio($socio);

                return new JsonResponse(['status' => 'Se ha actualizado correctamente'], Response::HTTP_OK);
            }
        }
        else 
        {
            return new JsonResponse(['error' => 'Ya existe un socio con ese email'], Response::HTTP_PARTIAL_CONTENT);
        }
    }
    
    /**
     * @Route("socio/{id}", name="delete_socio", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        $socio = $this->socioRepository->findOneBy(['id' => $id]);
        
        $this->socioRepository->removeSocio($socio);
        
        return new JsonResponse(['status' => 'Se ha borrado correctamente'], Response::HTTP_OK);
    }
}
