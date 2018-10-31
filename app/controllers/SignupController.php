<?php

class SignupController extends \Phalcon\Mvc\Controller
{
	public function indexAction(){

	}

	public function registerAction()
	{
			$usuario = new Usuario();
			//Almacenar y comprobar errores
			$success = $usuario->save(
					$this->request->getPost(),
					[
							"id",
							"nombre",
							"apPaterno",
							"apMaterno",
							"sexo",
							"fechaNac",
							"usuario",
							"pswd",
					]
			);

			if ($success) {
					echo "¡Gracias por registrarte!";
			} else {
					echo "Lo sentimos, se generaron los siguiente problemas: ";

					$messages = $usuario->getMessages();

					foreach ($messages as $message) {
							echo $message->getMessage(), "<br/>";
					}
			}
			//$this->view->disable();
	}
}
