<?php

namespace usuario;

class Usuario extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var string
     */
    protected $apPaterno;

    /**
     *
     * @var string
     */
    protected $apMaterno;

    /**
     *
     * @var string
     */
    protected $sexo;

    /**
     *
     * @var string
     */
    protected $fechaNac;

    /**
     *
     * @var string
     */
    protected $usuario;

    /**
     *
     * @var string
     */
    protected $pswd;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field nombre
     *
     * @param string $nombre
     * @return $this
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Method to set the value of field apPaterno
     *
     * @param string $apPaterno
     * @return $this
     */
    public function setApPaterno($apPaterno)
    {
        $this->apPaterno = $apPaterno;

        return $this;
    }

    /**
     * Method to set the value of field apMaterno
     *
     * @param string $apMaterno
     * @return $this
     */
    public function setApMaterno($apMaterno)
    {
        $this->apMaterno = $apMaterno;

        return $this;
    }

    /**
     * Method to set the value of field sexo
     *
     * @param string $sexo
     * @return $this
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Method to set the value of field fechaNac
     *
     * @param string $fechaNac
     * @return $this
     */
    public function setFechaNac($fechaNac)
    {
        $this->fechaNac = $fechaNac;

        return $this;
    }

    /**
     * Method to set the value of field usuario
     *
     * @param string $usuario
     * @return $this
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Method to set the value of field pswd
     *
     * @param string $pswd
     * @return $this
     */
    public function setPswd($pswd)
    {
        $this->pswd = $pswd;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Returns the value of field apPaterno
     *
     * @return string
     */
    public function getApPaterno()
    {
        return $this->apPaterno;
    }

    /**
     * Returns the value of field apMaterno
     *
     * @return string
     */
    public function getApMaterno()
    {
        return $this->apMaterno;
    }

    /**
     * Returns the value of field sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Returns the value of field fechaNac
     *
     * @return string
     */
    public function getFechaNac()
    {
        return $this->fechaNac;
    }

    /**
     * Returns the value of field usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Returns the value of field pswd
     *
     * @return string
     */
    public function getPswd()
    {
        return $this->pswd;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("evaluaciondocente");
        $this->setSource("usuario");
        $this->hasMany('id', 'usuario\Infoalumno', 'id', ['alias' => 'Infoalumno']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'usuario';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuario[]|Usuario|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Usuario|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
