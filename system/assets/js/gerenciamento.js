$(function() {
    
    /*
     *  MÁSCARAS 
     */
    $("input[rel='matricula']").mask('999.999-9');
    $("input[rel='data']").mask('99/99/9999');
    $("input[rel='cpf']").mask('999.999.999-99');
    $("input[rel='telefone']").mask('(99)9999-9999');
	$("input[rel='cep']").mask('99999-999');
	$("input[rel='cnpj']").mask('99.999.999/9999-99');
    $("input[rel='placa']").mask('***-9999');
    $("input[rel='prefixo']").mask('*-99');
    $("input[rel='renavam']").mask('99999999-9');

    /**
     * Botões que ativam buscas em formulários! 
     */
    $("#bt-buscar-sala").click(function() {
        $.ajax({
            type: 'get',
            url: BASE_URL + 'rh/salas/listar_salas',
            data: {
                nome: $("#nome").val()
            },
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#bt-buscar-lotacao").click(function() {
        $.ajax({
            type: 'get',
            url: BASE_URL + 'rh/lotacao/listar_lotacoes/',
            data: {
                nome: $("#nome").val()
            },
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#bt-buscar-turma").click(function() {
        $.ajax({
            type: 'get',
            url: BASE_URL + 'rh/ferias/consultar_turma/',
            data: {
                numero: $("#numero").val(), 
                exercicio: $("#exercicio").val()
            },
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#bt-buscar-militar").click(function(){
        $.ajax({
            type: 'get', 
            url: BASE_URL + 'rh/militares/listar_militares/', 
            data: {
                nome: $("#nome").val(), 
                matricula: $("#matricula").val()
            }, 
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#bt-buscar-chefias").click(function(){
        $.ajax({
            type: 'get', 
            url: BASE_URL + 'rh/chefias/consultar_chefias/', 
            data: {
                matricula: $("#matricula").val()
            }, 
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#btn-buscar-afastamentos").click(function(event) {
        $.ajax({
            type: 'get',
            url: BASE_URL + 'rh/afastamentos/consulta_afastamentos/',
            data: {
                chefe_militares_id_hidden: $('#chefe_militares_id_hidden').val(), 
                numero_processo: $("#numero_processo").val()
            },
            success: function(result) {
                $("#result-search").html(result);
            }
        });
    });

    $("#btn-buscar-militares-ferias").click(function(event) {
        $.ajax({
            url: BASE_URL + 'rh/ferias/resultado_consulta_ferias/',
            type: 'get',
            data: {
                exercicio: $("#exercicio").val(), 
                numero: $("#numero").val(), 
                matricula: $("#matricula").val()
            },
        })
        .success(function(result) {
            $("#result-search").html(result);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    });

    // Função que faz consulta via ajax de militares cadastrados. 
    $("#search-militar-matricula").keyup(function() {
        var matricula = $(this).val();
        if (matricula.length == 9) {
            $("#nome_militar").html('<img src="../../assets/img/ajax-loader.gif" />');
            $.ajax({
                type: 'get',
                url: BASE_URL + 'rh/militares/getMilitarByMatricula',
                dataType: 'json',
                data: {
                    matricula: matricula
                },
                success: function(result) {
                    if (result.militar != "") {
                        $("#nome_militar").html(result.militar.nome);
                        $('#chefe_militares_id_hidden').val(result.militar.id);
                    } else {
                        $("#nome_militar").html("Militar não encontrado");
                        $("#chefe_militares_id").val("");
                    }
                }
            });
        }
    });
	
	$('#dadosEndereco').hide();
	
	$('#loader').hide();
	
	/*$("#cep").blur(function() {
		$('#loader').hide();
	});*/
	
	$("#cep").keyup(function(){
		var cep = $(this).val().replace('-', '');
		cont=0;
		for(i=0;i<8;i++){
			if(cep[i]=="_") {				
				cont++;
			}
		}
		if(cont==0) {
			//$("#cep").html('<img src="../../assets/img/ajax-loader.gif" />').delay(9000);
			$.ajax({
				type: 'get',
				url: 'http://cep.correiocontrol.com.br/'+ cep +'.json', 
				dataType: 'json',
				data: {
					cep: $('#cep').val()
				}, 
				beforeSend: function(){
					$('#loader').show();
					//$('#loader').show(function(){
						//complete: $('#loader').hide();
				},
				success: function(result) {					
					$('#loader').fadeOut(2000, function(){
						complete: $('#dadosEndereco').fadeIn()
					});	
					
					// alert(cep);
					$("#inputEstado").val(result.uf);//+'/'+localidade);
					$("#inputEnd").val(result.logradouro);
					$("#inputBairro").val(result.bairro);
					$("#inputCidade").val(result.localidade);
				},
				error: function(result) {
					/*if(result.erro == true) {*/
						$('#loader').hide();
						$('#dadosEndereco').hide();	
						alert('Verifique o CEP digitado e tente novamente.');
						
					/*}*/
					//else $('#loader').hide();
				}
			});
		}
		else{
			$('#dadosEndereco').hide();
			$('#loader').hide();
		}
	});
	

    $("#exercicio-ferias").change(function(){
        $.ajax({
            type: 'get', 
            url: BASE_URL + 'rh/ferias/consultaDadosTurmas/', 
            data: {
                exercicio: $("#exercicio-ferias").val()
            },
            success: function(result) {
                $("#turmas").html(result);
            }
        });
    });

    $("#selMarca").change(function(){
        $.ajax({
            type: 'get', 
            url: BASE_URL + 'frotas/viaturas/carregaModelos/', 
            data: {
                marca: $("#selMarca").val()
            },
            success: function(result) {
                $("#selModelo").html(result);
            }
        });
    });
}); // Função Principal.

// Função que exibe Modal de confirmação.
function confirmarExcluir(url) {
    $("#bt-modal-confirmar-exclusao").attr('href', url);
}
