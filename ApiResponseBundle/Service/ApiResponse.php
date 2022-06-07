<?php
namespace App\ApiResponseBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


use App\ApiResponseBundle\Exception\ValidException;
use App\ApiResponseBundle\Exception\FatalException;
use App\ApiResponseBundle\Exception\ConstraintException;
use App\ApiResponseBundle\Exception\AccessDeniedException;
use App\ApiResponseBundle\Exception\NotFoundException;

use App\ApiResponseBundle\Model\DataResponse as Data;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiResponse
{
    private $srv_params = null;


    public function __construct(ParameterBagInterface $params)
    {
        $this->srv_params = new Data($this->params->get("app.ministerio"),
                                    $this->params->get("app.nombre"),
                                    $this->params->get("app.secretaria"),
                                    $this->params->get('app.version')
                                );
    }



    /**
      *  Genera un JsonResponse con HTTP_BAD_REQUEST
      *  Cuando no es Debug
      *  ValidException - Retorna todos los datos de la Exception
      *  FatalException - Solo Retormar el mensaje de la Exception
      *  Exception - Retorma un mensaje generico de Error
      * 
      *  @param type $exception ValidException, FatalException, Exception
      *
      *  @return JsonResponse HTTP_BAD_REQUEST
      */
    public function returnException($exception)
    {
        if ($exception instanceof ValidException)
        {
            return $this->BAD_REQUEST($this->jsonException("ValidException", $exception->getData(), $exception->getMessage()));
        }
        elseif ($exception instanceof FatalException)
        {
            if ($this->isDebug())
            {
                return $this->BAD_REQUEST($this->jsonException("FatalException", $exception->getData(), $exception->getMessage()));
            }
            else
            {
                return $this->BAD_REQUEST($this->jsonException("FatalException", "", $exception->getMessage()));
            }
        }
        elseif ($exception instanceof ConstraintException)
        {
            return $this->BAD_REQUEST($this->jsonException("ConstraintException", $exception->getData(), $exception->getMessage()));
        }
        elseif ($exception instanceof AccessDeniedException)
        {
            return $this->HTTP_UNAUTHORIZED($this->jsonException("AccessDeniedException", $exception->getData(), $exception->getMessage()));
        }
        elseif ($exception instanceof NotFoundException)
        {
            return $this->NOT_FOUND($this->jsonException("NotFoundException", $exception->getData(), $exception->getMessage()));
        }
        else
        {
            if ($this->isDebug())
            {
                return $this->BAD_REQUEST($this->jsonException("Exception", "", $exception->getMessage()));
            }
            else
            {
                return $this->BAD_REQUEST($this->jsonException("Exception", "", "Error en la Aplicación"));
            }
        }
    }


    /**
      *     Método que generará una respuesta JSON con los datos que se le pasen, he incorporará los datos de
      *  pertenecia del sistema (Ministerio, nombre, etc).
      *
      *  @param     mixed|null  $data       Puede ser cualquier tipo de información o null (en los casos de errores).
      *  @param     boolean     $include    Valor booleano que determinara si se deben agregar o no los datos de
      *                                  pertenencia en la respuesta que se genere.
      *  @param     boolean     $json       Especifica si los datos ya vienen en formato JSON.
      *
      *  @return    JsonResponse
      */
    public function JsonResponse($data = null, bool $include = true, bool $json = false): JsonResponse
    {
        $datos = null;

        $data = $json ? json_decode($data) : $data;

        if ($include)
        {
            $datos = $this->srv_params;
            $datos->setData($data);
        }
        else
            { $datos = $data; }
        
        $response = new JsonResponse();
        $response->setData($datos);

        return $response;
    }


    /**
      *  Retorna TRUE cuando no es Produccion
      *
      *  @return boolean
      */
    protected function isDebug() { return true; }


    private function jsonException($type, $data = null, $title = "")
    {
        if ($data !== null)
            { $data = $this->normalize($data); }
        
        return ["type" => $type, "data" => $data, "title" => $title];
    }


    /**
      *  Genera un HTTP 204
      * 
      *  @return JsonResponse
      */
    protected function NO_CONTENT()
    {
        $response = new JsonResponse(NULL, Response::HTTP_NO_CONTENT);

        return $response;
    }


    /**
      * Genera un HTTP 400
      * 
      * @param string/object/array $error Error para enviar a la aplicación
      *
      * @return JsonResponse
      */
    protected function BAD_REQUEST($error)
    {
        $response = new JsonResponse($error, Response::HTTP_BAD_REQUEST);

        return $response;
    }
    

    /**
      * Genera un HTTP 401
      * 
      * @param string/object/array $error Error para enviar a la aplicación
      * 
      * @return JsonResponse
      */
    protected function HTTP_UNAUTHORIZED($error)
    {
        $response = new JsonResponse($error, Response::HTTP_UNAUTHORIZED);

        return $response;
    }


    /**
      *  Genera un HTTP 404
      * 
      *  @param string/object/array $error Error para enviar a la aplicación
      * 
      *  @return JsonResponse
      */
    protected function NOT_FOUND($error)
    {
        $response = new JsonResponse($error, Response::HTTP_NOT_FOUND);

        return $response;
    }


    protected function normalize($data, $format = null, array $context = array(), array $ignoredAttributes = array())
    {
        $normalizer = new ObjectNormalizer();
        
        if (count($ignoredAttributes) > 0)
            { throw new \Exception("Error en BaseController::setIgnoredAttributes", 1); }
        
        $serializer = new Serializer(array($normalizer));

        return $serializer->normalize($data, $format, $context);
    }
}