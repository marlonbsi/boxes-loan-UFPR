function testaCPF(elemento) {
	cpf = elemento.value;
	cpf = cpf.replace(/[^\d]+/g, '');
	if (cpf == '') return elemento.style.color = "red";;
	// Elimina CPFs invalidos conhecidos    
	if (cpf.length != 11 ||	cpf == "00000000000" ||	cpf == "11111111111" ||	cpf == "22222222222" ||
		cpf == "33333333333" ||	cpf == "44444444444" ||	cpf == "55555555555" ||	cpf == "66666666666" ||
		cpf == "77777777777" ||	cpf == "88888888888" ||	cpf == "99999999999"){
		//	alert("CPF inválido!");
			return elemento.style.color = "red";
	}
	// Valida 1o digito 
	add = 0;
	for (i = 0; i < 9; i++){
		add += parseInt(cpf.charAt(i)) * (10 - i);
	}
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11){
		rev = 0;
	}
	if (rev != parseInt(cpf.charAt(9))){
		//alert("CPF inválido!");
		return elemento.style.color = "red";
	}
	// Valida 2o digito 
	add = 0;
	for (i = 0; i < 10; i++){
		add += parseInt(cpf.charAt(i)) * (11 - i);
	}
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11){
		rev = 0;
	}
	if (rev != parseInt(cpf.charAt(10))){
		//alert("CPF Inválido");
		return elemento.style.color = "red";
	} else{
		return elemento.style.color = "green";
	}
}

function testaNome(elemento_nome) {
	nome = elemento_nome.value;
	if (nome.length < 3 || nome.length > 50 || nome == null){
	//	alert("Um nome válido deve ser informado!");
		return elemento_nome.style.color = "red";
	}else{
		var regex = '[^a-zA-Z éúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ]+';
		if(nome.match(regex)) {
		//	alert("Um nome válido deve ser informado!");
			return elemento_nome.style.color = "red";
		}else{
			return elemento_nome.style.color = "green";
		}
	}
}

function testaTelefone(elemento_telefone) {
	telefone = elemento_telefone.value;
	if (telefone.length < 10 || telefone.length > 15 || telefone == null){
	//	alert("Um telefone válido deve ser informado!");
		return elemento_telefone.style.color = "red";
	}else{
		var regex = '[^0-9 ()-]+';
		if(telefone.match(regex)) {
	//		alert("Um telefone válido deve ser informado!");
			return elemento_telefone.style.color = "red";
		}else{
			return elemento_telefone.style.color = "green";
		}
	}
}

function testaEmail(elemento_email) {
	email = elemento_email.value;
	if (email.length < 10 || email.length > 80 || email == null){
	//	alert("Uma instituicao válida deve ser informada!");
		return elemento_email.style.color = "red";
	}else{
		var regex = '[^a-zA-Z0-9@.]+';
		if(email.match(regex)) {
	//		alert("Uma instituicao válida deve ser informada!");
			return elemento_email.style.color = "red";
		}else{
			return elemento_email.style.color = "green";
		}
	}
}

function testaInstituicao(elemento_instituicao) {
	instituicao = elemento_instituicao.value;
	if (instituicao.length < 3 || instituicao.length > 50 || instituicao == null){
	//	alert("Uma instituicao válida deve ser informada!");
		return elemento_instituicao.style.color = "red";
	}else{
		var regex = '[^a-zA-Z éúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ]+';
		if(instituicao.match(regex)) {
	//		alert("Uma instituicao válida deve ser informada!");
			return elemento_instituicao.style.color = "red";
		}else{
			return elemento_instituicao.style.color = "green";
		}
	}
}