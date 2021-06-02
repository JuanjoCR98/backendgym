<?php

namespace App\Controller;

use App\Repository\EmpleadoRepository;
use App\Repository\RedSocialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Firebase\JWT\JWT;
use App\Entity\Empleado;
use App\Entity\RedSocial;
use DateTime;

class EmpleadoController extends AbstractController
{
    private $empleadoRepository;
    private $redSocialRepository;

    public function __construct(EmpleadoRepository $empleadoRepository, RedSocialRepository $redSocialRepository)
    {
        $this->empleadoRepository = $empleadoRepository;
        $this->redSocialRepository = $redSocialRepository;
    }

      /**
     * @Route("/empleado", name="getall_empleados", methods={"GET"})
     */
    public function obtenerTodos()
    {
        $empleados = $this->empleadoRepository->findAll();
        
         $data = [];

        foreach ($empleados as $empleado) {
            $data[] = [
                'id' => $empleado->getId(),
                'email' => $empleado->getEmail(),
                'nombre' => $empleado->getNombre(),
                'apellidos' => $empleado->getApellidos(),
                'fecha_nac' => $empleado->getFechaNac(),
                'foto' => $empleado->getFoto(),
                'roles' => $empleado->getRoles(),
                'facebook'=>$empleado->getRedesSociales()->getFacebook(),
                'twitter' => $empleado->getRedesSociales()->getTwitter(),
                "instagram" => $empleado->getRedesSociales()->getInstagram()
            ];
        }
        
        if(sizeof($data) == 0)
        {
            return new JsonResponse(["status"=>"No hay ningún empleado"], Response::HTTP_PARTIAL_CONTENT);
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
      /**
     * @Route( "/empleado/{id}" , name="get_empleado", methods={"GET"})
     */
    public function obtenerEmpleado(int $id)
    {
        $empleado = $this->empleadoRepository->findOneBy(["id" => $id]);
        
        if($empleado == null)
        {
             return new JsonResponse(['error' => 'No existe ningún empleado con ese id'], Response::HTTP_PARTIAL_CONTENT);
        }
        
        $data = [
            'id' => $empleado->getId(),
            'email' => $empleado->getEmail(),
            'nombre' => $empleado->getNombre(),
            'apellidos' => $empleado->getApellidos(),
            'fecha_nac' => $empleado->getFechaNac(),
            'foto' => $empleado->getFoto(),
            'roles' => $empleado->getRoles(),
            'facebook' => $empleado->getRedesSociales()->getFacebook(),
            'twitter' => $empleado->getRedesSociales()->getTwitter(),
            "instagram" => $empleado->getRedesSociales()->getInstagram()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
    
        /**
     * @Route("/empleado/login", name="login", methods={"POST"})
     */
    public function login(Request $request) {
        $data = json_decode($request->getContent(),true);
        
        $email = $data['email'];
        $password = $data['password'];
        
        $empleado = $this->empleadoRepository->findOneBy(['email' => $email]);
        
        if(empty($email) || empty($password))
        {
            return new JsonResponse(['error' => 'Todos los campos son obligatorios. Introduzca todos los campos'], Response::HTTP_PARTIAL_CONTENT);   
        }
        else if($empleado == null)
        {
            return new JsonResponse(['error' => 'Empleado no válido. '], Response::HTTP_NOT_FOUND);   
        }
        else if(!password_verify($password, $empleado->getPassword()))
        {
          return new JsonResponse(['error' => 'Empleado no válido.Introduzca correctamente su email y contraseña.'], Response::HTTP_NOT_FOUND);  
        }
        else {
            $payload = [
            "user" => $empleado->getEmail(),
            "exp" => (new \DateTime())->modify("+5 day")->getTimestamp(),
            ];

            $jwt = JWT::encode($payload, $this->getParameter('jwt_secret'), 'HS256');

            return new JsonResponse([
            'respuesta' => 'Empleado logueado correctamente',
            'token' => $jwt,], Response::HTTP_OK);
        }
    }
    
     /**
     * @Route("/empleado", name="registrar_empleado", methods={"POST"})
     */
    public function registrar(Request $request) {
        $data = json_decode($request->getContent(),true);
        
        $email = $data['email'];
        $password = $data['password'];
        $nombre = $data['nombre'];
        $apellidos = $data['apellidos'];
        $fecha_nac = $data['fecha_nac'];
        $foto= $data['foto'];
        $roles = $data['roles'];
        
        $facebook = $data['facebook'];
        $twitter = $data['twitter'];
        $instagram = $data['instagram'];
        
        $empleado_tmp = $this->empleadoRepository->findOneBy(["email" => $email]);
        
        if(empty($email)||empty($password)||empty($roles)||empty($nombre)||empty($apellidos)||empty($fecha_nac)){
            return new JsonResponse(['error' => 'Todos los campos son obligatorios. Introduzca todos los campos'], Response::HTTP_PARTIAL_CONTENT);
        }
        else if($empleado_tmp != null)
        {
            return new JsonResponse(['error' => 'Ya existe un empleado con ese email'], Response::HTTP_PARTIAL_CONTENT);
        }
        else if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            return new JsonResponse(['error' => 'Formato de email no válido.'], Response::HTTP_PARTIAL_CONTENT);
        }
        else if(strlen($password) < 4)
        {
            return new JsonResponse(['error' => 'La contraseña debe de tener al menos 4 caracteres'], Response::HTTP_PARTIAL_CONTENT);
        }
        else
        {
            $empleado = new Empleado();

            $empleado->setEmail($email);
            $empleado->setPassword(password_hash($password, PASSWORD_BCRYPT));
            $empleado->setNombre($nombre);
            $empleado->setApellidos($apellidos);
            $date = new DateTime($fecha_nac);
            $empleado->setFechaNac($date);
            $empleado->setFoto($foto);
            $empleado->setRoles($roles);
             
            $redSocial = new RedSocial();
            $redSocial->setFacebook($facebook);
            $redSocial->setTwitter($twitter);
            $redSocial->setInstagram($instagram);
            
            $empleado->setRedesSociales($redSocial);
            
            $this->empleadoRepository->saveEmpleado($empleado);
            $this->redSocialRepository->saveRedSocial($redSocial);
            
            return new JsonResponse(['status' => 'Se ha registrado correctamente'], Response::HTTP_OK);
        }
    }
    
        /**
     * @Route("/empleado/{id}" , name="update_empleado" , methods={"PUT"})
     */
    public function modificarEmpleado(int $id, Request $request): JsonResponse 
    {
        $empleado = $this->empleadoRepository->findOneBy(["id" => $id]);

        $data = json_decode($request->getContent(), true);

        $existe_email = $this->empleadoRepository->findOneBy(array("email" => $data["email"]));

        if ($empleado != null) 
        {
            if (($empleado->getEmail() == $data["email"]) || $existe_email == null) 
            {
                if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) 
                {
                    return new JsonResponse(['error' => 'Formato de email no válido.'], Response::HTTP_PARTIAL_CONTENT);
                } 
                else if (!empty($data["password"]) && strlen($data["password"]) < 4) 
                {
                    return new JsonResponse(['error' => 'La contraseña debe de tener al menos 4 caracteres'], Response::HTTP_PARTIAL_CONTENT);
                } 
                else {
                    empty($data["email"]) ? true : $empleado->setEmail($data["email"]);
                    empty($data["nombre"]) ? true : $empleado->setNombre($data["nombre"]);
                    empty($data["apellidos"]) ? true : $empleado->setApellidos($data["apellidos"]);
                    empty($data["password"]) ? true : $empleado->setPassword(password_hash($data["password"], PASSWORD_BCRYPT));
                    empty($data["fecha_nac"]) ? true : $empleado->setFechaNac(new DateTime($data["fecha_nac"]));
                    empty($data["roles"]) ? true : $empleado->setRoles($data["roles"]);
                    empty($data["foto"]) ? true : $empleado->setFoto($data["foto"]);
                    empty($data["facebook"]) ? true : $empleado->getRedesSociales()->setFacebook($data["facebook"]);
                    empty($data["twitter"]) ? true : $empleado->getRedesSociales()->setTwitter($data["twitter"]);
                    empty($data["instagram"]) ? true : $empleado->getRedesSociales()->setInstagram($data["instagram"]);

                    $this->empleadoRepository->updateEmpleado($empleado);
                }
                return new JsonResponse(['status' => 'Se ha actualizado correctamente'], Response::HTTP_OK);
            } 
            else {
                return new JsonResponse(['error' => 'Ya existe un empleado con ese email'], Response::HTTP_PARTIAL_CONTENT);
            }
        } 
        else {
            return new JsonResponse(["error" => "No hay ningún empleado con ese id"], Response::HTTP_PARTIAL_CONTENT);
        }
    }

    /**
     * @Route("empleado/{id}", name="delete_empleado", methods={"DELETE"})
     */
    public function borrarEmpleado(int $id): JsonResponse
    {
        $empleado = $this->empleadoRepository->findOneBy(['id' => $id]);
        
        if($empleado == null)
        {
            return new JsonResponse(["error"=>"No hay ningún empleado con ese id"], Response::HTTP_PARTIAL_CONTENT);
        }
        else{
           $this->empleadoRepository->removeEmpleado($empleado); 
        }
        
        return new JsonResponse(['status' => 'Se ha borrado correctamente'], Response::HTTP_OK);
    }
}
