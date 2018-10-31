<h1>Usuario</h1>
<ul>
<?php foreach ($usuario as $u) { ?>
	<li><?= $this->tag->linkTo(['usuario/infoAlumno/' . $u->usuario, $u->usuario . ' -> ' . $u->nombre . ' ' . $u->apPaterno]) ?></li>
<?php } ?>
</ul></ul>