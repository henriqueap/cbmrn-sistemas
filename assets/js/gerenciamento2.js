 $(function() {
    
    /* 
     *  MÁSCARAS 
     */
    $("input[rel='placa']").mask('***-9999');
    $("input[rel='prefixo']").mask('*-99');
    $("input[rel='chassis']").mask('*****************');
    $("input[rel='renavam']").mask('99999999-9');
    $("input[rel='matricula']").mask('999.999-9');
    $("input[rel='data']").mask('99/99/9999');
    $("input[rel='cpf']").mask('999.999.999-99');
    $("input[rel='telefone']").mask('(99)9999-9999');
	$("input[rel='cep']").mask('99999-999');
	$("input[rel='cnpj']").mask('99.999.999/9999-99');

    
    // Erro ao usar essa funcção em javascript!
    $("input[rel='preco']").maskMoney({ prefix:'R$ ', allowNegative: false, thousands:'.', affixesStay: false });

    $('#operacional').hide();
    $('#administrativa').hide();

    // Função que idenfica o tipo da viatura 
    $(".tipo_viatura").change(function() {
        $.ajax({
            type: 'get',
            url: BASE_URL + 'index.php/frotas/odometro/tipoViatura/',
            data: {
                tipoViatura: $(".tipo_viatura").val()
            },
            success: function(result) {
                $('#operacional').show();
                $('#administrativa').show();
            }
        });
    });
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
	
	//filtro de dados em odometro
	 $("#btn-buscar-filtro").click(function(event) {
       // alert('Ola');
		$.ajax({
            url: BASE_URL + 'frotas/listar_viaturas/listarOdometrosFiltrar/',
            type: 'get',
            data: {
				id:$("#inputIdViaturas").val(),
                data_inicial: $("#dataInicial").val(), 
                data_final: $("#dataFinal").val(), 
            },
			success: function(result) {
                $("#result-search").html(result);
				$('#semFiltro').hide();
            }
        });
    });
	
	//filtro de dados em abastecimento
	 $("#btn-buscar-filtro-abastecimento").click(function(event) {
       // alert('Ola');
		$.ajax({
            url: BASE_URL + 'frotas/listar_viaturas/listarAbastecimentosFiltrar/',
            type: 'get',
            data: {
				id:$("#inputIdViaturas").val(),
                data_inicial: $("#dataInicial").val(), 
                data_final: $("#dataFinal").val(), 
            },
			success: function(result) {
                $("#result-search").html(result);
				$('#semFiltro').hide();
            }
        });
    });
	
	//filtro de dados em Servicos
	 $("#btn-buscar-filtro-servicos").click(function(event) {
       // alert('Ola');
		$.ajax({
            url: BASE_URL + 'frotas/listar_viaturas/listarServicosFiltrar/',
            type: 'get',
            data: {
				id:$("#inputIdViaturas").val(),
				idTipo:$("#selTipo").val(),
                data_inicial: $("#dataInicial").val(), 
                data_final: $("#dataFinal").val(), 
            },
			success: function(result) {
                $("#result-search").html(result);
				$('#semFiltro').hide();
            }
        });
    });
	
	//filtro de dados em Listar geral
	 $("#btn-buscar-filtro-viaturas").click(function(event) {
       // alert('Ola');
		$.ajax({
            url: BASE_URL + 'frotas/listar_viaturas/listarFiltrar/',
            type: 'get',
            data: {
				/*idViatura:$("#idViatura").val(),*/
				idLotacao:$("#selLotacao").val(),
                tipo: $("#selTipoViatura").val(), 
            },
			success: function(result) {
                $("#result-search").html(result);
				$('#semFiltro').hide();
				$('#modal').hide();
            }
        });
    });

	//filtro de dados em relatorio geral
	 $("#btn-buscar-filtro-relatorio").click(function(event) {
       // alert('Ola');
		$.ajax({
            url: BASE_URL + 'frotas/relatorio_geral/relatorioFiltrar/',
            type: 'get',
            data: {
				/*idViatura:$("#idViatura").val(),*/
				idLotacao:$("#selLotacao").val(),
                tipo: $("#selTipoViatura").val(), 
            },
			success: function(result) {
                $("#result-search").html(result);
				$('#semFiltro').hide();
				
            }
        });
    });

     //filtro de dados em listar concluidos
     $("#btn-buscar-filtro-concluidos").click(function(event) {
       // alert('Ola');
        $.ajax({
            url: BASE_URL + 'frotas/servicos_concluidos/listarFiltrar/',
            type: 'get',
            data: {
                viaturas_id:$("#idViatura").val(),
                data_inicio: $("#dataInicial").val(), 
                data_fim: $("#dataFinal").val(),  
            },
            success: function(result) {
                $("#result-search").html(result);
                $('#semFiltro').hide();
                
            }
        });
    });
     //filtro por data para servicos pendentes
    $("#btn-buscar-filtro-pendentes").click(function(event) {
       // alert('Ola');
        $.ajax({
            url: BASE_URL + 'frotas/servicos_pendentes/listarFiltrar/',
            type: 'get',
            data: {
                data_inicio: $("#dataInicial").val(), 
                data_fim: $("#dataFinal").val(),  
            },
            success: function(result) {
                $("#result-search").html(result);
                $('#semFiltro').hide();
                
            }
        });
    });

     //filtro cancelado e autorizados
   /* $("#btn-buscar-filtro-cancelados-nao-autorizados").click(function(event) {
       // alert('Ola');
        $.ajax({
            url: BASE_URL + 'frotas/servicos_cancelados_autorizados/listarFiltrar/',
            type: 'get',
            data: {
                intTipo: $("#intTipo").val(), 
                data_inicio: $("#dataInicial").val(), 
                data_fim: $("#dataFinal").val(),  
                 
            },
            success: function(result) {
                $("#result-search").html(result);
                $('#semFiltro').hide();
                
            }
        });
    });*/

    // Botão para buscar informações sobre exercicios.
    $("#buscar-sustar-ferias").click(function(event) {
      $.ajax({
            type: 'get',
            url: BASE_URL + 'rh/ferias/get_militares_ferias',
            data: {
                exercicio: $("#exercicio").val(), 
                militar: $("#chefe_militares_id_hidden").val()
            },
            success: function(result) {
                $("body").html(result);
            }, 
            fail: function(result) {
                $("body").html(result);
            }
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
    /*$('#loader2').hide();

    $('#formComplete').hide(); 

    $('#inputCNPJ').keyup(function(){
        var cnpj =  $(this).val().replace('.','');
        cnpj =  cnpj.replace('.','');
        cnpj =  cnpj.replace('-','');
        cnpj =  cnpj.replace('/','');
        cont=0;
        for(i=0;i<14;i++){
            if(cnpj[i]=="_") {               
                cont++;
            }
        }
        if(cont==0) {

            var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
            digitos_iguais = 1;
            if (cnpj.length < 14 && cnpj.length < 15){
                return false;
            }
            for (i = 0; i < cnpj.length - 1; i++)
                if (cnpj.charAt(i) != cnpj.charAt(i + 1))
            {
                digitos_iguais = 0;
                break;
            }
            if (!digitos_iguais)
            {
                tamanho = cnpj.length - 2
                numeros = cnpj.substring(0,tamanho);
                digitos = cnpj.substring(tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--)
                {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0)){
                    $('#loader2').hide();
                    $('#formComplete').hide(); 
                    alert('Verifique o CNPJ digitado e tente novamente.');
                    return false;
                }
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0,tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--)
                {
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2)
                        pos = 9;
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1)){
                    $('#loader2').hide();
                    $('#formComplete').hide(); 
                    alert('Verifique o CNPJ digitado e tente novamente.');
                    return false;
                    
                }
                
                $('#loader2').fadeOut(2000, function(){
                    complete: $('#formComplete').fadeIn()
                }); 
                return true;
            }else{
                $('#loader2').hide();
                $('#formComplete').hide(); 
                alert('Verifique o CNPJ digitado e tente novamente.');
                 return false;
            }
        }
        else{
            $('#loader2').hide();
            $('#formComplete').hide();
            }
    }); */

	$('#autorizacaoModal').hide();

    $('#empresasInoperantes').hide();

    $('#autorizacao').click(function () {
        $("#autorizacaoModal").show();
    });

	$('#dadosEndereco').hide();
	
	$('#loader').hide();

	$('#cep').keyup(function(){
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
						alert('Verifique o CEP digitado ou a sua conexão, tente novamente mais tarde.');
						
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

  // Funções Criadas Para o CLOG.
    // Botão para consultar estoque de produtos. 
    $("#consulta-estoque").click(function(event) {
        $.ajax({
            url: BASE_URL + 'index.php/clog/produtos/consulta_estoque/',
            type: 'GET',
            data: {
                modelo: $("#modelo").val(), 
                marcas: $("#marcas_produtos_id").val(), 
            },
            success: function(result) { 
                $("#result-search").html(result); 
            }
        });
    });

    // Botão que consulta dados dos produtos.
    $("#consulta-produtos").click(function(event) { 
        $.ajax({
            url: BASE_URL + 'index.php/clog/produtos/consulta_produtos/',
            type: 'GET',
            data: {
                marcas_produtos_id: $("#marcas_produtos_id").val(), 
                grupo_produtos: $("#grupo_produtos").val(), 
                modelo: $("#modelo").val(), 
            },
            success: function(result) { $("#result-search").html(result); }
        });
    });

    // Botão para consultar dados das empresas.
    $("#consulta-empresa").click(function(event) {
        $.ajax({
            url: BASE_URL + 'index.php/clog/empresa/consultaEmpresa/',
            type: 'GET',
            data: {
                razao_social: $("#razao_social").val(), 
                nome_fantasia: $("#nome_fantasia").val(), 
                cnpj: $("#cnpj").val()
            },
            success: function(result) { $("#result-search").html(result); }
        });
    });

    // Botão Click.
    $("#btn-compra").click(function(event) { $("#tipo_nota_fiscal").val('0'); });
    $("#btn-servico").click(function(event) { $("#tipo_nota_fiscal").val('1'); });

    $("#btn-concluir-nota").click(function(event) {
        $.ajax({
            url: BASE_URL + 'index.php/clog/notas/concluir_notas_fiscais/',
            type: 'GET',
            data: {
                valor: $("#valor").val(), 
                id: $("#id").val() 
            },
            success: function (result) {
               $("body").html(result);
            },
            fail: function(result) {
                $("body").html(result);
            }
        }).done(function() { console.log("success"); }).fail(function() { console.log("error"); }).always(function() { console.log("complete"); });
    }); 

    $("#consulta-nota-fiscal").click(function(event) {
        $.ajax({
            url: BASE_URL + 'index.php/clog/notas/consulta_notas_fiscais/',
            type: 'GET',
            data: {
                nota_fiscal: $("#nota_fiscal").val(), 
                data: $("#data").val(), 
                empresas_id: $("#empresas_id").val()
            },
            success: function(result) { $("#result-search").html(result); }
        });
    });

    // Select para pegar valor.
    $("#div_numero_tombo").hide();
    $("#select-tombo").change(function(event) {
        if ($('#select-tombo').val() == 1) {
          $("#div_numero_tombo").show();  
        };
    });
}); // Função Principal.


$('#ckbkm').click(function () {
    if ($('#ckbkm').is(':checked')) { 
        $('#txtOleo').prop('disabled', false); 
        $('#txtOleo').addClass('required'); 
    } else { $('#txtOleo').prop('disabled', true); 
    $('#txtOleo').removeClass('required'); 
    }
});
$('#btnSalvar').click(function () {
    $('#inputCidade').prop('disabled', false);
    $('#inputEstado ').prop('disabled', false);
});


// Função que exibe Modal de confirmação.
function confirmarExcluir(url) {
    $("#bt-modal-confirmar-exclusao").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarDesativarViatura(url) {
    $("#bt-modal-confirmar-desativar-viatura").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarViatura(url) {
    $("#bt-modal-confirmar-reativar-viatura").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarCancelarServico(url) {
    $("#bt-modal-confirmar-cancelar-servico").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarEntregaServico(urlEntrega) {
    $("#bt-modal-confirmar-entrega").attr('href', urlEntrega);
}






