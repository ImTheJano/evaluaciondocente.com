<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class UsuarioController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for usuario
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Usuario', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $usuario = Usuario::find($parameters);
        if (count($usuario) == 0) {
            $this->flash->notice("The search did not find any usuario");

            $this->dispatcher->forward([
                "controller" => "usuario",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $usuario,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a usuario
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $usuario = Usuario::findFirstByid($id);
            if (!$usuario) {
                $this->flash->error("usuario was not found");

                $this->dispatcher->forward([
                    'controller' => "usuario",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $usuario->getId();

            $this->tag->setDefault("id", $usuario->getId());
            $this->tag->setDefault("nombre", $usuario->getNombre());
            $this->tag->setDefault("apPaterno", $usuario->getAppaterno());
            $this->tag->setDefault("apMaterno", $usuario->getApmaterno());
            $this->tag->setDefault("sexo", $usuario->getSexo());
            $this->tag->setDefault("fechaNac", $usuario->getFechanac());
            $this->tag->setDefault("usuario", $usuario->getUsuario());
            $this->tag->setDefault("pswd", $usuario->getPswd());
            
        }
    }

    /**
     * Creates a new usuario
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $usuario = new Usuario();
        $usuario->setnombre($this->request->getPost("nombre"));
        $usuario->setapPaterno($this->request->getPost("apPaterno"));
        $usuario->setapMaterno($this->request->getPost("apMaterno"));
        $usuario->setsexo($this->request->getPost("sexo"));
        $usuario->setfechaNac($this->request->getPost("fechaNac"));
        $usuario->setusuario($this->request->getPost("usuario"));
        $usuario->setpswd($this->request->getPost("pswd"));
        

        if (!$usuario->save()) {
            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("usuario was created successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a usuario edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $usuario = Usuario::findFirstByid($id);

        if (!$usuario) {
            $this->flash->error("usuario does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        $usuario->setnombre($this->request->getPost("nombre"));
        $usuario->setapPaterno($this->request->getPost("apPaterno"));
        $usuario->setapMaterno($this->request->getPost("apMaterno"));
        $usuario->setsexo($this->request->getPost("sexo"));
        $usuario->setfechaNac($this->request->getPost("fechaNac"));
        $usuario->setusuario($this->request->getPost("usuario"));
        $usuario->setpswd($this->request->getPost("pswd"));
        

        if (!$usuario->save()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'edit',
                'params' => [$usuario->getId()]
            ]);

            return;
        }

        $this->flash->success("usuario was updated successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a usuario
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $usuario = Usuario::findFirstByid($id);
        if (!$usuario) {
            $this->flash->error("usuario was not found");

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'index'
            ]);

            return;
        }

        if (!$usuario->delete()) {

            foreach ($usuario->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "usuario",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("usuario was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "usuario",
            'action' => "index"
        ]);
    }

}
