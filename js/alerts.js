alertify.defaults.transition = "fade";
alertify.defaults.theme.ok = "btn btn-primary";
alertify.defaults.theme.cancel = "btn btn-danger";
alertify.defaults.theme.input = "form-control";
function showAlert(titulo,mensaje){
	alertify.alert(titulo,mensaje);
}
function modalError(titulo,error){
	alertify.alert(titulo,error);
}
function modalSuccess(titulo,mensaje){
	alertify.alert(titulo,mensaje);
}
