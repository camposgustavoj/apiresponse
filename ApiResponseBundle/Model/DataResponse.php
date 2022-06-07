<?php

/**
  *     Clase que establecerá la estructura de datos que serán retornados en un JsonResponse.
  *  
  *  
  *  @author Gustavo Sánchez <sanchezg@santafe.gov.ar>
  *  
  *  @version 1.0.0
  *  @copyright 2022 Ministerio de Gobierno, Justicia y Derechos Humanos
  *  
  *  @access public
  */

namespace App\ApiResponseBundle\Model;


class DataResponse
{
    /**
      *  Atributo que tendrá el nombre del Ministerio.
      *  
      *  @var string|null
      */
    public $ministerio = null;

    /**
      *  Atributo que contendrá el nombre del Sistema.
      *  
      *  @var string|null
      */
    public $nombre = null;

    /**
      *  Atributo que almacenará el nombre de una Secretaria.
      *  
      *  @var string|null
      */
    public $secretaria = null;

    /**
      *  Atributo que poseerá la versión en la que se encuentre el Sistema.
      *  
      *  @var string|null
      */
    public $version = null;

    /**
      *  Atributo que dispondrá de distintos tipos de datos, dependiendo donde se utilice.
      *  
      *  @var mixed|null
      */
    public $data = null;


    public function __construct(string $ministerio, string $nombre, string $secretaria, string $version, mixed $data = null)
    {
        $this->setMinisterio($ministerio);
        $this->setNombre($nombre);
        $this->setSecretaria($secretaria);
        $this->setVersion($version);
        $this->setData($data);
    }

    public function __destruct()
    {
        $this->ministerio = null;
        $this->nombre = null;
        $this->secretaria = null;
        $this->version = null;
        $this->data = null;
    }
    

    /**
      *     Método que retornará el nombre del Ministerio.
      *  
      *  @return    string
      */ 
    public function getMinisterio(): string
        { return $this->ministerio; }

    /**
      *     Método que establecerá el nombre del Ministerio.
      *  
      *  @param     string      $ministerio
      *
      *  @return    void
      */ 
    public function setMinisterio(string $ministerio)
        { $this->ministerio = $ministerio; }


    /**
      *     Método que devolverá el nombre del Sistema.
      *  
      *  @return    string
      */ 
    public function getNombre(): string
        { return $this->nombre; }

    /**
      *     Método que especificará el nombre del Sistema.
      *  
      *  @param     string      $nombre
      *  
      *  @return    void
      */ 
    public function setNombre(string $nombre)
        { $this->nombre = $nombre; }


    /**
      *     Método que regresará el nombre de una Secretaria.
      *  
      *  @return    string
      */ 
    public function getSecretaria(): string
        { return $this->secretaria; }

    /**
      *  Método que almacenará el nombre de una Secretaria.
      *
      *  @param     string      $secretaria
      *  
      *  @return    void
      */ 
    public function setSecretaria(string $secretaria)
        { $this->secretaria = $secretaria; }


    /**
      *     Método que regresará la versión del Sistema.
      *  
      *  @return    string
      */ 
    public function getVersion(): string
        { return $this->version; }

    /**
      *     Método que especficará la versión del Sistema.
      *
      *  @param     string      $version
      *  
      *  @return    void
      */ 
    public function setVersion(string $version)
    {
        $this->version = $version;
    }


    /**
      *     Método que retornará información, si es que existe.
      *  
      *  @return      mixed|null
      */ 
    public function getData()
        { return $this->data; }

    /**
      *     Método que establecerá información, la cual podría ser de diferentes tipos.
      *  
      *  @param     mixed       $data
      * 
      *  @return    void
      */ 
    public function setData($data)
    {
        $this->data = $data;
    }
}