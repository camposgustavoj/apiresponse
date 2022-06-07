<?php
namespace MJYDH\ApiResponseBundle\Exception;

/**
 * Description of ContexException
 *
 * @author Usuario
 */
class AccessDeniedException extends \Exception {

    private $data = null;
    private $title = null;
    
    /**
    * Constructor
    * @param string $message Descripcion del la excepción lanzada
    * @param int $code Default = 0, Codigo de error de la excepción
    * @param Exception $previous Excepcion anterior
    */
    public function __construct($title, $message, $data = null) {
        $this->data = $data;
		$this->title = $title;
        parent::__construct($message, 0);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function getData(){
        return $this->data;
    }
	
	public function getTitle(){
		return $this->title;
	}
}
