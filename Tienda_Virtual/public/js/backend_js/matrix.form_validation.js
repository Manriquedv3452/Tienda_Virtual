
$(document).ready(function(){

	// Revision de contraseña
	$('ctr_nueva').keyup(function(){
		var ctr_actual = $('ctr_actual').val();
		$.ajax({
			type: 'get',
			url:'admin/revisarContrasena',
			data:{ctr_actual:ctr_actual},
			success:function(resp){
				if(resp=="false"){
					$("#revisarContrasena").html("<font color='red'> Contraseña Actual Incorrecta.</font>");
				} else if(resp=="true"){
					$("#revisarContrasena").html("<font color='green'> Contraseña Actual Correcta.</font>");
				}
			}, error:function(){
				alert("Error");
			}
		});
	});

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	// Validacion de agregar Categoría
	$("#agregarCategoria").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			descripcion:{
				required: true,
				maxlength:200
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de editar Categoría
	$("#editarCategoria").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			condicion:{
				required: true,
				digits: true,
				max: 1
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de agregar Producto
	$("#agregarProducto").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			categorias:{
				required: true
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			imageInput:{
				required: true
			},
			precio:{
				required: true,
				number: true,
				min: 1,
				maxlength: 45,
			},
			disponibles:{
				required: true,
				digits: true,
				min: 0,
				max: 100
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de editar Producto
	$("#editarProducto").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			categorias:{
				required: true
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			imageInput:{
				required: true
			},
			precio:{
				required: true,
				number: true,
				min: 1,
				maxlength: 45,
			},
			disponibles:{
				required: true,
				digits: true,
				min: 0,
				max: 100
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Confirmar Validacion de contraseña
	$("#crearAdmin").validate({
		rules:{
			nombre:{
				required: true,
				minlength: 3
			},
			correo:{
				required: true,
				email: true
			},
			ctr_nueva:{
				required: true,
				rangelength: [8,20]
			},
			ctr_confirmar:{
				required:true,
				rangelength: [8,20],
				equalTo:"#ctr_nueva"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Confirmar Validacion de contraseña
	$("#crearAdmin").validate({
		rules:{
			nombre:{
				required: true,
				minlength: 3
			},
			correo:{
				required: true,
				email: true
			},
			ctr_nueva:{
				required: true,
				rangelength: [8,20]
			},
			ctr_confirmar:{
				required:true,
				rangelength: [8,20],
				equalTo:"#ctr_nueva"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Confirmar Validacion de contraseña
	$("#validarContrasena").validate({
		rules:{
			ctr_actual:{
				required: true,
				minlength:6,
				maxlength:20
			},
			ctr_nueva:{
				required: true,
				rangelength: [8,20]
			},
			ctr_confirmar:{
				required:true,
				rangelength: [8,20],
				equalTo:"#ctr_nueva"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Ventana emergente de eliminación de Categoría
	$(".elimiarCategoria").click(function(){
		if(confirm('¿Está seguro que desea eliminar esta categoría?')){
			return true;
		}
		return false;
	});

	// Ventana emergente de eliminación de Producto
	$(".delProd").click(function(){
		if(confirm('¿Está seguro que desea eliminar este producto?')){
			return true;
		}
		return false;
	});
});
