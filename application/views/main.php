
<!DOCTYPE html>
<html>
<head>
	<title> Página principal </title>
</head>
<body>
	<h1> 
		Bem-vindo <br>
		Visualize aqui todos os feriados disponíveis esse ano 
	</h1>
	<select id='selectEstado'> 
		<option id="9999" selected  disabled> Selecione um Estado </option>
	</select>
	<select id='selectCidade'> 
		<option id="9999" selected  disabled> Selecione uma cidade </option>
	</select>
	<button id="btnGerar"> Gerar </button>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
<script type="text/javascript">
$.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados', function(data){
	var tamanhoJson = Object.keys(data).length
	var selectBody = '';
	for(var i= 0; i < tamanhoJson;  i++){
		var nome = data[i].nome
		var id = data[i].id
		var sigla = data[i].sigla
		selectBody += "<option id= " + id + " data-sigla=" + sigla +">" + nome + "</option>"  
	}
	$('#selectEstado')[0].innerHTML += selectBody;
})
$('#selectEstado').change(function(data){
	$('#selectCidade')[0].innerHTML = '<option id="9999" selected  disabled> Selecione uma cidade </option>'
	var select = $('#selectEstado')[0]
	var idEstado = select.options[select.selectedIndex].id
	$.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' + idEstado + '/municipios', function(dataCidade){
		var tamanhoJson = Object.keys(dataCidade).length
		var selectBody = '';
		for(var i= 0; i < tamanhoJson;  i++){
			var nome = dataCidade[i].nome
			var id = dataCidade[i].id
			selectBody += "<option id= " + id + ">" + nome + "</option>"  
		}
		$('#selectCidade')[0].innerHTML += selectBody;
	})
})
$('#btnGerar').click(function(data){
	var select = $('#selectCidade')[0]
	var idCidade = select.options[select.selectedIndex].id
	if(idCidade == '9999'){
		console.log(idCidade)
		return
	}
	var ano = new Date().getFullYear()
	console.log(idCidade)
	$.get('https://api.calendario.com.br/?ano='+ ano + '&ibge='+ idCidade +'&token=YmFvLmVtZXJzb25AZ21haWwuY29tJmhhc2g9NjQxMzY1OTI&json=true',function(data){
		
	})

})

</script>