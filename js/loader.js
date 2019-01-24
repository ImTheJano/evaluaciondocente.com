function loaderBlocks(tag){
	tag.html('<center class="my-0"><p class="lead text-info my-0">Cargando...</p></center>');
	var row=$('<div class="row"></div>');
	var col=$('<div class="col-4 offset-4"></div>');
	var container=$('<div>',{
		'class':'lds-css ng-scope'
	});
	var loader=$('<div>',{
		'class':'lds-blocks',
		'style':'100%;height:100%'
	});
	var block1=$('<div>',{'style':'left:38px;top:38px;animation-delay:0s'})
	var block2=$('<div>',{'style':'left:80px;top:38px;animation-delay:0.125s'})
	var block3=$('<div>',{'style':'left:122px;top:38px;animation-delay:0.25s'})
	var block4=$('<div>',{'style':'left:38px;top:80px;animation-delay:0.875s'})
	var block5=$('<div>',{'style':'left:122px;top:80px;animation-delay:0.375s'})
	var block6=$('<div>',{'style':'left:38px;top:122px;animation-delay:0.75s'})
	var block7=$('<div>',{'style':'left:80px;top:122px;animation-delay:0.625s'})
	var block8=$('<div>',{'style':'left:122px;top:122px;animation-delay:0.5s'})
	loader.append(block1).append(block2).append(block3).append(block4).append(block5).append(block6).append(block7).append(block8);
	row.append(col);
	col.append(container)
	container.append(loader);
	// <link rel="stylesheet" href="css/loader/blocks.css">
	css=$('<link>',{
		'rel':'stylesheet',
		'href':'css/loader/blocks.css'
	})
	tag.append(css);
	tag.append(row);
}
function loadSpinnerGrow(tag,mensaje='Cargando...'){
	tag.html('');
	function createSpinner(color,size){
		spinner=
		$('<div>',{
			'class':'spinner-grow text-'+color,
			'role':'status',
			'style':'width: '+size+'rem; height: '+size+'rem;'
		}).append($('<span>',{
				'class':'sr-only',
				'html':'<center class="text-muted">'+mensaje+'</center>'
			})
		);
		return spinner;
	}
	container=$('<div>',{
		'class':'d-flex justify-content-center',
	})
		.append(createSpinner('info',5))
		.append(createSpinner('warning',4))
		.append(createSpinner('danger',2))
	tag.append(container);
	tag.append('<div class="d-flex justify-content-center text-muted my-4"><center>'+mensaje+'</center></div>')
}
function loadPage(tag,page,lag=1000,mensaje='Cargando...'){
	loadSpinnerGrow(tag,mensaje);
	setTimeout(function(){tag.load(page);}, lag);
}
