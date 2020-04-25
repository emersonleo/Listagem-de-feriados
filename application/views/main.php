
<!DOCTYPE html>
<html>
<head>
	<title> Página principal </title>
	<script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
	 integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
	<button id="btnGerar" data-toggle="modal" data-target="#modalFeriado"> Gerar </button>

	<div class="modal" id="modalFeriado" tabindex="-1" role="dialog" >
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"> Feriados </h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <table id='tableModal'>
	        	<thead>
	        		
	        	</thead>
	        	<tbody id='tbodyModal'>
	        		
	        	</tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	      	<button > Baixar planilha </button>
	      </div>

	    </div>
	  </div>
	</div>
</body>
</html>


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
		return
	}
	var ano = new Date().getFullYear()
	$.get('https://api.calendario.com.br/?ano='+ ano + '&ibge='+ idCidade +'&token=YmFvZW1lcnNvbjE1QGdtYWlsLmNvbSZoYXNoPTEzNjcxNzIxMA&json=true',function(dataFeriado){
		console.log(dataFeriado)
		var tamanhoJson = Object.keys(dataFeriado).length
		var strTbody = '';
		for(var i= 0; i < tamanhoJson; i++){
			strTbody += '<tr align="center"><td style="width:30%">' +  dataFeriado[i].date + '</td> <td style="width:50%">' + dataFeriado[i].name + '</td></tr>'
		}
		$("#tbodyModal")[0].innerHTML = strTbody
	})

})


</script>