jQuery(function( $ ) {

	//MÁSCARAS
	$("input[rel='placa']").mask('***-9999');
	$("input[rel='prefixo']").mask('**-99');
	$("input[rel='chassis']").mask('*****************');
	$("input[rel='renavam']").mask('9999999999-9');
	$("input[rel='matricula']").mask('999.999-9');
	$("input[rel='data']").mask('99/99/9999');
	$("input[rel='cpf']").mask('999.999.999-99');
	$("input[rel='telefone']").mask('(99)9999-9999');
	$("input[rel='celular']").mask('(99)99999-9999');
	$("input[rel='cep']").mask('99999-999');
	$("input[rel='cnpj']").mask('99.999.999/9999-99');
	$("input[rel='preco']").maskMoney({prefix: 'R$ ', decimal: ',', precision: 2, allowNegative: false, thousands: '.', affixesStay: false});
	$("input[rel='cod']").mask('999/9999');
	$("input[rel='hora']").mask('99:99');
	$("input[rel='ano']").mask('9999');
	//.MASCARAS

	$(".data").datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
		dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
		dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
		monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});

	$.datepicker.setDefaults({
		showOn: "both",
		buttonImageOnly: true,
		buttonImage: "calendar.gif",
		buttonText: "Calendar"
	});

	// Calendar Focus
	$(".input-group-addon").click(function (event) {
		$(this).next().focus();
	});

	//Select2

	$('#produtos').select2({
		placeholder: "Selecione Produtos",
		maximumSelectionSize: 1
	});

	$('#produtos_cautela').select2({
		placeholder: "Selecione Produtos",
		maximumSelectionSize: 1
	});

	$('#empresas_id').select2({
		placeholder: "Selecione Fornecedor",
		maximumSelectionSize: 1
	});

	$('#marcas_produtos_id').select2({
		placeholder: "Selecione Marca de Produtos",
		maximumSelectionSize: 1
	});

	$('#grupo_produtos').select2({
		placeholder: "Selecione o Grupo de Produtos",
		maximumSelectionSize: 1
	});

	$('#militares_id').select2({
		placeholder: "Selecione o Militar",
		maximumSelectionSize: 1
	});

	$('#grupos_id').select2({
		placeholder: "Selecione o Grupo de Permissões",
		maximumSelectionSize: 1
	});

	$('#localidade').select2({
		placeholder: "Selecione a Localidade Desejada",
		maximumSelectionSize: 1
	});

	$('#tipo_ocorrencia').select2({
		placeholder: "Selecione a Tipo de Ocorrência",
		maximumSelectionSize: 1
	});
	//Select2 - End

	$('#operacional').hide();
	$('#administrativa').hide();

	// Função que idenfica o tipo da viatura
	$(".tipo_viatura").change(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/frotas/odometro/tipoViatura/',
			data: {
				tipoViatura: $(".tipo_viatura").val()
			},
			success: function (result) {
				$('#operacional').show();
				$('#administrativa').show();
			}
		});
	});

	/**
	 * Botões que ativam buscas em formulários!
	 */
	$("#bt_lista_solicitacoes").click(function () {
		event.preventDefault();
		var a=$(this);
		var row=a.data('turma');
		//row.attr('href', BASE_URL + 'index.php/rh/cursos/listar_solicitacoes?id=' + row);
		consulta = $.ajax({
			url: BASE_URL + 'index.php/rh/cursos/listar_solicitacoes',	
			type: 'GET',
			data: {
				id: row
			}
		});
		consulta.done(function (result) {
			$("#militares_turma").html(result);
		});
		consulta.fail(function (result) {
			alert('Consulta falhou, tente novamente mais tarde!');
		});
	});

	$("#bt-buscar-sala").click(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/salas/listar_salas',
			data: {
				nome: $("#nome").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#bt-buscar-lotacao").click(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/lotacao/listar_lotacoes/',
			data: {
				nome: $("#nome").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#bt-buscar-turma").click(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/ferias/consultar_turma/',
			data: {
				numero: $("#numero").val(),
				exercicio: $("#exercicio").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#bt-buscar-militar").click(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/militares/listar_militares/',
			data: {
				nome: $("#nome").val(),
				matricula: $("#matricula").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#bt-buscar-chefias").click(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/chefias/consultar_chefias/',
			data: {
				matricula: $("#matricula").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#btn-buscar-afastamentos").click(function (event) {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/afastamentos/consulta_afastamentos/',
			data: {
				chefe_militares_id_hidden: $('#chefe_militares_id_hidden').val(),
				numero_processo: $("#numero_processo").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#btn-buscar-militares-ferias").click(function (event) {
		$.ajax({
			url: BASE_URL + 'index.php/rh/ferias/resultado_consulta_ferias/',
			type: 'get',
			data: {
				exercicio: $("#exercicio").val(),
				numero: $("#numero").val(),
				matricula: $("#matricula").val()
			}
		})
			.success(function (result) {
				$("#result-search").html(result);
			})
			.fail(function () {
				console.log("error");
			})
			.always(function () {
				console.log("complete");
			});
	});

	//Filtro de dados em odometro
	$("#btn-buscar-filtro").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/listar_viaturas/listarOdometrosFiltrar/',
			type: 'get',
			data: {
				id: $("#inputIdViaturas").val(),
				data_inicial: $("#dataInicial").val(),
				data_final: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro de dados em abastecimento
	$("#btn-buscar-filtro-abastecimento").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/listar_viaturas/listarAbastecimentosFiltrar/',
			type: 'get',
			data: {
				id: $("#inputIdViaturas").val(),
				data_inicial: $("#dataInicial").val(),
				data_final: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro de dados em Servicos
	$("#btn-buscar-filtro-servicos").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/listar_viaturas/listarServicosFiltrar/',
			type: 'get',
			data: {
				id: $("#inputIdViaturas").val(),
				idTipo: $("#selTipo").val(),
				data_inicial: $("#dataInicial").val(),
				data_final: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro de dados em Listar geral
	$("#btn-buscar-filtro-viaturas").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/listar_viaturas/listarFiltrar/',
			type: 'get',
			data: {
				/*idViatura:$("#idViatura").val(),*/
				idLotacao: $("#selLotacao").val(),
				tipo: $("#selTipoViatura").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
				$('#modal').hide();
			}
		});
	});

	//Filtro de dados em relatorio geral
	$("#btn-buscar-filtro-relatorio").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/relatorio_geral/relatorioFiltrar/',
			type: 'get',
			data: {
				/*idViatura:$("#idViatura").val(),*/
				idLotacao: $("#selLotacao").val(),
				tipo: $("#selTipoViatura").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro de dados em listar concluidos
	$("#btn-buscar-filtro-concluidos").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/servicos_concluidos/listarFiltrar/',
			type: 'get',
			data: {
				viaturas_id: $("#idViatura").val(),
				data_inicio: $("#dataInicial").val(),
				data_fim: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro por data para servicos pendentes
	$("#btn-buscar-filtro-pendentes").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/servicos_pendentes/listarFiltrar/',
			type: 'get',
			data: {
				data_inicio: $("#dataInicial").val(),
				data_fim: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	//Filtro cancelado e autorizados
	$("#btn-buscar-filtro-cancelados-nao-autorizados").click(function (event) {
		$.ajax({
			url: BASE_URL + 'frotas/servicos_cancelados_autorizados/listarFiltrar/',
			type: 'get',
			data: {
				intTipo: $("#intTipo").val(),
				data_inicio: $("#dataInicial").val(),
				data_fim: $("#dataFinal").val()
			},
			success: function (result) {
				$("#result-search").html(result);
				$('#semFiltro').hide();
			}
		});
	});

	// Botão para buscar informações sobre exercicios.
	$("#buscar-sustar-ferias").click(function (event) {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/ferias/get_militares_ferias',
			data: {
				exercicio: $("#exercicio").val(),
				militar: $("#militar_id_hidden").val()
			},
			success: function (result) {
				$("body").html(result);
			},
			fail: function (result) {
				$("body").html(result);
			}
		});
	});

	// Função que faz consulta via ajax de militares cadastrados - Depois atualizar em outras páginas
	$("#search-id-matricula").keyup(function () {
		var matricula = $(this).val();
		if (matricula.length == 9) {
			//$("#nome_militar").html('<img src="http://192.168.0.6/sistemas/assets/img/ajax-loader.gif" />'); //Dev
			$("#nome_militar").html('<img src="http://www2.defesasocial.rn.gov.br/cbmrn/new/assets/img/ajax-loader.gif" />'); //COINE
			$.ajax({
				type: 'get',
				url: BASE_URL + 'index.php/rh/militares/getMilitarByMatricula',
				dataType: 'json',
				data: {
					matricula: matricula
				},
				success: function (result) {
					if (result.militar != "") {
						$("#nome_militar").html(result.militar.nome);
						$('#militar_id_hidden').val(result.militar.id);
					} else {
						$("#nome_militar").html("Militar não encontrado");
						$("#militar_id").val("");
					}
				}
			});
		}
	});

	// Função que faz consulta via ajax de militares cadastrados.
	$("#search-militar-matricula").keyup(function () {
		var matricula = $(this).val();
		if (matricula.length == 9) {
			//$("#nome_militar").html('<img src="http://192.168.0.6/sistemas/assets/img/ajax-loader.gif" />'); //Dev
			$("#nome_militar").html('<img src="http://www2.defesasocial.rn.gov.br/cbmrn/new/assets/img/ajax-loader.gif" />'); //COINE
			$.ajax({
				type: 'get',
				url: BASE_URL + 'index.php/rh/militares/getMilitarByMatricula',
				dataType: 'json',
				data: {
					matricula: matricula
				},
				success: function (result) {
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

	$('#loader2').hide();
	$('#formComplete').hide();

	$('#inputCNPJ').keyup(function () {
		var cnpj = $(this).val().replace('.', '');
		cnpj = cnpj.replace('.', '');
		cnpj = cnpj.replace('-', '');
		cnpj = cnpj.replace('/', '');
		cont = 0;
		for (i = 0; i < 14; i++) {
			if (cnpj[i] == "_") {
				cont++;
			}
		}
		if (cont == 0) {
			var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
			digitos_iguais = 1;
			if (cnpj.length < 14 && cnpj.length < 15) {
				return false;
			}
			// Merda!
			for (i = 0; i < cnpj.length - 1; i++)
				if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
					digitos_iguais = 0;
					break;
				}
			if (!digitos_iguais) {
				tamanho = cnpj.length - 2
				numeros = cnpj.substring(0, tamanho);
				digitos = cnpj.substring(tamanho);
				soma = 0;
				pos = tamanho - 7;
				for (i = tamanho; i >= 1; i--) {
					soma += numeros.charAt(tamanho - i) * pos--;
					if (pos < 2)
						pos = 9;
				}
				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
				if (resultado != digitos.charAt(0)) {
					$('#loader2').hide();
					$('#formComplete').hide();
					$("#inputCNPJ").val() == ""; //* Pereira
					alert('Verifique o CNPJ digitado e tente novamente.');
					return false;
				}

				tamanho = tamanho + 1;
				numeros = cnpj.substring(0, tamanho);
				soma = 0;
				pos = tamanho - 7;

				for (i = tamanho; i >= 1; i--) {
					soma += numeros.charAt(tamanho - i) * pos--;
					if (pos < 2) {
						pos = 9;
					}
				}

				resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

				if (resultado != digitos.charAt(1)) {
					$('#loader2').hide();
					$('#formComplete').hide();
					$("#inputCNPJ").val() == ""; //* Pereira
					alert('Verifique o CNPJ digitado e tente novamente.');
					return false;
				}

				$('#loader2').fadeOut(2000, function () {
					complete: $('#formComplete').fadeIn()
				});
				return true;
			} else {
				$('#loader2').hide();
				$('#formComplete').hide();
				$("#inputCNPJ").val() == ""; //* Pereira
				alert('Verifique o CNPJ digitado e tente novamente.');
				return false;
			}
		}
		else {
			$('#loader2').hide();
			$('#formComplete').hide();
		}
	});

	$('#autorizacaoModal').hide();
	$('#empresasInoperantes').hide();
	$('#autorizacao').click(function () {
		$("#autorizacaoModal").show();
	});

	$("#exercicio-ferias").change(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/rh/ferias/consultaDadosTurmas/',
			data: {
				exercicio: $("#exercicio-ferias").val()
			},
			success: function (result) {
				$("#turmas").html(result);
			}
		});
	});

	// Frotas

	$("#max-odometro").html("");
	$("#max-odometro").hide();
	$('#semViatura').hide();

	$("#selViatura").change(function () {
		var opt_vtr = $("#selViatura").val();
		var vtr_id = opt_vtr.split('-')[0];
		var tipo_vtr = opt_vtr.split('-')[1];
		$("#semViatura").show();

		//alert(tipo_vtr+'-'+vtr_id);

		/*if (tipo_vtr == '2') {
			$("#semViatura").show();
		}
		else {
			$("#semViatura").hide();
		}*/
		
		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/frotas/odometro/getMaxOdometro',
			data: {
				id: vtr_id
			},
			dataType: "html"
		}).done(function(result) {
			$("#max-odometro").html(result);
			$("#max-odometro").show();
		});

		$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/frotas/odometro/getInfoDestino',
			data: {
				id: vtr_id
			},
			dataType: "html"
		}).done(function(result) {
			$("#semViatura").show();
			$("#semViatura").html(result);
		});

		/*$.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/frotas/odometro/getInfoDestino',
			//url: "http://sistemascbm.rn.gov.br/sistemas/index.php/frotas/odometro/getInfoDestino",
			data: {
				id: vtr_id
			},
			success: function (result) {
				$("#semViatura").show();
				$("#semViatura").html(result);
				/*$("#inputDestino").prop( "disabled", true)
				if (! result) {
					$("#inputDestino").prop( "disabled", false)
				}
			}
		});*/
	});

	$("#selSetorVtr").change(function () {
		var lotacoes_id = $("#selSetorVtr").val();
		
		tag = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/frotas/abastecimento/loadVtrSetor',
			data: {
				id: lotacoes_id
			}
		});
		tag.done(function (result) {
			$("#seletor_viaturas").empty();
			$("#seletor_viaturas").html(result);
		});
	});

	$('#dadosEndereco').hide();
	$('#loader').hide();

	$('#cep').keyup(function () {
		var cep = $(this).val().replace('-', '');
		cont = 0;
		for (i = 0; i < 8; i++) {
			if (cep[i] == "_") {
				cont++;
			}
		}
		if (cont == 0) {
			//$("#cep").html('<img src="http://192.168.0.6/sistemas/assets/img/ajax-loader.gif" />'); //Dev
			$("#cep").html('<img src="http://www2.defesasocial.rn.gov.br/cbmrn/new/assets/img/ajax-loader.gif" />'); //COINE
			$.ajax({
				type: 'get',
				url: 'http://cep.correiocontrol.com.br/' + cep + '.json',
				dataType: 'json',
				data: {
					cep: $('#cep').val()
				},
				beforeSend: function () {
					$('#loader').show();
					// $('#loader').show(function(){
					// complete: $('#loader').hide();
				},
				success: function (result) {
					$('#loader').fadeOut(2000, function () {
						complete: $('#dadosEndereco').fadeIn()
					});

					$("#inputEstado").val(result.uf);//+'/'+localidade);
					$("#inputEnd").val(result.logradouro);
					$("#inputBairro").val(result.bairro);
					$("#inputCidade").val(result.localidade);
				},
				error: function (result) {
					$('#loader').hide();
					$('#dadosEndereco').hide();
					alert('Verifique o CEP digitado ou a sua conexão, tente novamente mais tarde.');
				}
			});
		} else {
			$('#dadosEndereco').hide();
			$('#loader').hide();
		}
	});

	$("#selMarca").change(function () {
		$.ajax({
			type: 'get',
			url: BASE_URL + 'frotas/viaturas/carregaModelos/',
			data: {
				marca: $("#selMarca").val()
			},
			success: function (result) {
				$("#selModelo").html(result);
			}
		});
	});

	// Click Button.
	$('#ckbkm').click(function () {
		if ($('#ckbkm').is(':checked')) {
			$('#txtOleo').prop('disabled', false);
			$('#txtOleo').addClass('required');
		}
		else {
			$('#txtOleo').prop('disabled', true);
			$('#txtOleo').removeClass('required');
		}
	});

	$('#ckbExtra').click(function () {
		if ($('#ckbExtra').is(':checked')) {
			$('#ckbExtra').val('1');
		} else {
			$('#ckbExtra').val('0');
		}
	}); // Pereira

	$('#btnSalvar').click(function () {
		$('#inputCidade').prop('disabled', false);
		$('#inputEstado ').prop('disabled', false);
	});

	$('#btnSalvarOdom').click(function () {
		$('#semViatura').show();
	});

	// Sistema CLog
	// Botão para consultar estoque de produtos.
	$("#consulta-estoque").click(function (event) {
		$.ajax({
			url: BASE_URL + 'index.php/clog/produtos/consulta_estoque/',
			type: 'GET',
			data: {
				modelo: $("#modelo").val(),
				marcas: $("#marcas_produtos_id").val(),
				almox: $("#lotacoes_id").val(),
				tipo: $("#tipo_produto").val(),
				grupo_produtos: $("#grupo_produtos").val(),
				zerados: $("#zerados").prop( "checked" )
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#lista-produtos-estoque").click(function (event) {
		$.ajax({
			url: BASE_URL + 'index.php/clog/produtos/lista_produtos_estoque/',
			type: 'GET',
			data: {
				modelo: $("#modelo").val(),
				marcas: $("#marcas_produtos_id").val(),
				almox: $("#lotacoes_id").val(),
				tipo: $("#tipo_produto").val(),
				zerados: $("#zerados").prop( "checked" )
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	// Botão que consulta dados dos produtos.
	$("#consulta-produtos").click(function (event) {
		$.ajax({
			url: BASE_URL + 'index.php/clog/produtos/consulta_produtos/',
			type: 'GET',
			data: {
				marcas_produtos_id: $("#marcas_produtos_id").val(),
				grupo_produtos: $("#grupo_produtos").val(),
				modelo: $("#modelo").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	// Botão para consultar dados das empresas.
	$("#consulta-empresa").click(function (event) {
		$.ajax({
			url: BASE_URL + 'index.php/clog/empresa/consultaEmpresa/',
			type: 'GET',
			data: {
				razao_social: $("#razao_social").val(),
				nome_fantasia: $("#nome_fantasia").val(),
				cnpj: $("#cnpj").val()
			},
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	// Botão Click.
	$("#btn-compra").click(function (event) {
		$("#tipo_nota_fiscal").val('0');
	});
	
	$("#btn-servico").click(function (event) {
		$("#tipo_nota_fiscal").val('1');
		$("#btn-compra").removeClass("active");
	});

	//Input de tombamento
	$("#tombamento").hide();

	$("#tombo_info").hide();
	$("#tombo").keyup(function () {
		var numero = $(this).val();
		if (numero == '') {
			$("#tombo_info").hide();
		}
		else {
			retorno = $.ajax({
				type: 'get',
				url: BASE_URL + 'index.php/clog/clog/validarTombo',
				dataType: 'json',
				data: {
					tombo: numero
				}
			});
				retorno.done(function (result) {
					if (result.tombo && result.tombo.modelo != undefined && result.tombo.marca != undefined) {
						produto_info = result.tombo.modelo + " " + result.tombo.marca;
						if (result.tombo.setor != null) {
							if (result.tombo.sala == 1) {
								produto_info += ": Transferido para a sala "+ result.tombo.setor +", conforme Transferência nº " + result.tombo.cautelas_id + ". Indisponível";
							}
							else {
								produto_info += ": No estoque do " + result.tombo.setor + ". Disponível";
							}
						}
						if (result.tombo && result.tombo.cautelas_id != undefined) {
							$("#distro_id").val(result.tombo.cautelas_id);
							if (result.tombo.distribuicao == 1) {
								if (result.tombo.finalizada == 0) {
									produto_info += ": Em processo de distribuição, não concluída, sob nº " + result.tombo.cautelas_id + ". Indisponível";
								}
								if (result.tombo.finalizada == 1) {
									produto_info += ": Em posse do(a) "+ result.tombo.militar +", conforme Distribuicao nº " + result.tombo.cautelas_id + ". Indisponível";
								}
							}
							if (result.tombo.distribuicao == 0) {
								if (result.tombo.finalizada == 0) {
									produto_info += ": Em processo de cautela, não concluída, sob nº " + result.tombo.cautelas_id + ". Indisponível";
								}
								else {
									produto_info += ": Cautelado por "+ result.tombo.militar +", conforme Cautela nº " + result.tombo.cautelas_id + ". Indisponível";
								}
							}
						}
						$("#tombo_info").empty();
						$("#tombo_info").html(produto_info);
						$("#tombo_info").show();
					}
					else {
						produto_info = "Este número de tombo ainda não consta no sistema";
						$("#distro_id").val("");
						$("#tombo_info").html(produto_info);
						$("#tombo_info").show();
					}
				});
				retorno.fail(function (result) {
					$("#distro_id").empty();
					$("#tombo_info").empty();
					$("#tombo_info").hide();
				});
		}
	});

	// Alterado por Pereira
	$("#tombos-disp").hide();
	$("#div_numero_tombo").hide();
	// .Pereira

	$("#consumo").change(function () {
		// Incluído por Pereira
		if ($("#consumo").val() == 1) {
			$("#div_numero_tombo").show();
			$("#numero_tombo").prop('required', true);
		}
		else {
			$("#tombos-disp").hide();
			$("#numero_tombo").prop('required', false);
			$("#div_numero_tombo").hide();
		}
		produtos = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/clog/getProdutos',
			dataType: 'json',
			data: {
				consumo: $("#consumo").val(),
				estoque: $("#estoques_id").val()
			}
		});
		produtos.done(function (result) {
			$("#produtos_cautela").empty();
			if (result.produtos.length > 0) {
				$("#produtos_cautela").append(new Option("Selecione", "0"));
				for (var i = result.produtos.length - 1; i >= 0; i--) {
					$("#produtos_cautela").append(new Option(result.produtos[i].modelo, result.produtos[i].id));
				}
			}
		});
		// .Pereira
	});

	// Incluido por Pereira
	$("#produtos_cautela").change(function () {
		if ($("#consumo").val() == 1) {
			// Mostra a div para incluir os tombos
			$("#div_numero_tombo").show();
			// AJAX dos Tombos
			retorno = $.ajax({
				type: 'get',
				url: BASE_URL + 'index.php/clog/clog/getTombos',
				dataType: 'json',
				data: {
					id: $("#produtos_cautela").val(),
					estoque: $("#estoques_id").val()
				}
			});
			retorno.done(function (result) {
				if (result.tombos_produto.length > 0) {
					lista = "";
					for (var i = result.tombos_produto.length - 1; i >= 0; i--) {
						lista = lista + result.tombos_produto[i].tombo + "; ";
					}
					$("#tombos-disp").show();
					$("#tombos_produto").empty();
					$("#tombos_produto").html(lista);
					//$("#tombos_produto").show();
				}
				if (result.tombos_produto[0] == "Indisponível ou não existe tombos no estoque selecionado") {
					$("#tombos_produto").text("Indisponível");
				}
			});
			retorno.fail(function (result) {
				$("#tombos-disp").show();
				$("#tombos_produto").empty();
				$("#tombos_produto").text("Indisponível ou não existe tombos no estoque selecionado");
			});
		}
		else {
			$("#tombos-disp").hide();
			$("#div_numero_tombo").hide();
		}
	});

	$("#setores_patrimonio").change(function () {
		// Incluído por Pereira
		salas = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/cautelas/listaSalas',
			dataType: 'html',
			data: {
				id: $("#setores_patrimonio").val()
			}
		});
		salas.done(function (result) {
			$("#salas").html(result);
		});
		// .Pereira
	});
	// .Pereira

	$("#btn-concluir-nota").click(function (event) {
		conclui = $.ajax({
			url: BASE_URL + 'index.php/clog/notas/concluir_notas_fiscais',
			type: 'GET',
			data: {
				valor: $("#valor").val(),
				id: $("#id").val()
			}
		});
			conclui.done(function (result) {
				location.href = BASE_URL + 'index.php/clog/msgSystemAjax?msg=Nota Fiscal concluída com sucesso!&msgTp=success&pg=clog/notas';
			});			
	});

	$("#consulta-nota-fiscal").click(function (event) {
		filter = {
			nota_fiscal: $("#nota_fiscal").val(),
			empresas_id: $("#empresas_id").val()
		};
		if ($("#ano_nota").val() > 999) {
			filter['ano_nota'] = $("#ano_nota").val();
		}
		if ($("#data").val().length > 0) {
			var dtVal = $("#data").val().split("/");
			filter['data'] = dtVal[2] + "-" + dtVal[1] + "-" + dtVal[0];
		}
		$.ajax({
			url: BASE_URL + 'index.php/clog/notas/consulta_notas_fiscais/',
			type: 'GET',
			data: filter,
			success: function (result) {
				$("#result-search").html(result);
			}
		});
	});

	$("#produtos").change(function (event) {
		retorno = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/clog/detalhaProduto',
			dataType: 'json',
			data: {
				id: $("#produtos").val()
			}
		});
		retorno.done(function (result) {
			if (result.produto.consumo != undefined) {
				if (result.produto.consumo == "1") {
					$("#div_numero_tombo").show();
				}
				else {
					$("#div_numero_tombo").hide();
				}
			}
			else {
				$("#div_numero_tombo").hide();
			}
		});
		retorno.fail(function (result) {
			$("#div_numero_tombo").hide();
		});
	});

	$("#militares_id").change(function (event) {
		retorno = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/permissao/listarPermissoesUsuario',
			dataType: 'html',
			data: {
				id: $("#militares_id").val()
			}
		});
		retorno.done(function (result) {
			$("#lista_permissoes_usuario").html(result);
		});
		retorno.fail(function (result) {
			$("#lista_permissoes_usuario").empty();
		});
	});

	$("#grupos_id").change(function (event) {
		// Carrega as permissões do grupo na div
		permissoes_grupo = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/permissao/listarPermissoesGrupo',
			dataType: 'html',
			data: {
				id: $("#grupos_id").val()
			}
		});
		permissoes_grupo.done(function (result) {
			$("#lista_permissoes_grupo").html(result);
		});
		permissoes_grupo.fail(function (result) {
			$("#lista_permissoes_grupo").empty();
		});
		// Carrega as permissões que o grupo não tem no select
		permissoes = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/permissao/listarPermissoesGrupo',
			dataType: 'json',
			data: {
				id: $("#grupos_id").val(),
				json: 1
			}
		});
		permissoes.done(function (result) {
			$("#permissoes_id").empty();
			if (result.grupos.length > 0) {
				$("#permissoes_id").append(new Option("Selecione", "0"));
				for (var i = result.grupos.length - 1; i >= 0; i--) {
					$("#permissoes_id").append(new Option(result.grupos[i].permissao, result.grupos[i].permissoes_id));
				}
			}
		});
	});

	$("#btn-consulta-auditoria").click(function (event) {
		event.preventDefault();
		// Tratando data inicial
		if ($("#data_inicial").val() == "") {
			$("#data_inicial").val("01/01/2014");
			dtIniVal = $("#data_inicial").val().split("/");
			dtIni = dtIniVal[2] + "-" + dtIniVal[1] + "-" + dtIniVal[0];
		}
		else {
			dtIniVal = $("#data_inicial").val().split("/");
			dtIni = dtIniVal[2] + "-" + dtIniVal[1] + "-" + dtIniVal[0];
		}
		// Tratando data final
		if ($("#data_final").val() == "") {
			dataHj = new Date();
			dHj = (dataHj.getDate() > 9) ? dataHj.getDate() : "0" + dataHj.getDate();
			mHj = ((dataHj.getMonth() + 1) > 9) ? (dataHj.getMonth() + 1) : "0" + (dataHj.getMonth() + 1);
			aHj = dataHj.getFullYear();
			$("#data_final").val(dHj + "/" + mHj + "/" + aHj);
			dtFim = aHj + "-" + mHj + "-" + dHj;
		}
		else {
			dtFimVal = $("#data_final").val().split("/");
			dtFim = dtFimVal[2] + "-" + dtFimVal[1] + "-" + dtFimVal[0];
		}
		// Tratando data inicial > data final
		if (dtIni > dtFim) {
			alert("A data final não pode ser menor que a data inicial!!!");
			$("#data_final").val($("#data_inicial").val());
			dtFimVal = $("#data_final").val().split("/");
			dtFim = dtFimVal[2] + "-" + dtFimVal[1] + "-" + dtFimVal[0];
		}
		// Executando a consulta conforme o filtro
		audita = $.ajax({
			url: BASE_URL + 'index.php/clog/filtrar_auditoria?page=1',
			type: 'POST',
			dataType: 'html',
			data: {
				data_inicial: dtIni,
				data_final: dtFim,
				tipo_auditoria: $("#tipo_auditoria").val(),
				militares_id: $("#militares_id").val(),
				auditoria: $("#auditoria").val(),
				linhas: $("#linhas").val()
			}
		});
		audita.done(function (result) {
			$("#resultado_consulta").empty();
			$("#resultado_consulta").html(result);
		});
	});

	$("#data_final").change(function (event) {
		// Formatando as datas
		dtIniVal = $("#data_inicial").val().split("/");
		dtIni = dtIniVal[2] + "-" + dtIniVal[1] + "-" + dtIniVal[0];
		dtFimVal = $("#data_final").val().split("/");
		dtFim = dtFimVal[2] + "-" + dtFimVal[1] + "-" + dtFimVal[0];
		// Tratando as datas
		if (dtIni > dtFim) {
			alert("A data final não pode ser menor que a data inicial!!!");
			$("#data_final").val($("#data_inicial").val());
		}
		if (dtIni < "2014-01-01") {
			alert("A data final não pode ser menor que 01/01/2014!!!");
			$("#data_inicial").val('01/01/2014');
		}
	});

	$("#data_inicial").change(function (event) {
		// Formatando as datas
		dtIniVal = $("#data_inicial").val().split("/");
		dtIni = dtIniVal[2] + "-" + dtIniVal[1] + "-" + dtIniVal[0];
		dtFimVal = $("#data_final").val().split("/");
		dtFim = dtFimVal[2] + "-" + dtFimVal[1] + "-" + dtFimVal[0];
		// Tratando as datas
		if (dtIni > dtFim) {
			alert("A data final não pode ser menor que a data inicial!!!");
			$("#data_final").val($("#data_inicial").val());
		}
		if (dtIni < "2014-01-01") {
			alert("A data final não pode ser menor que 01/01/2014!!!");
			$("#data_inicial").val('01/01/2014');
		}
	});

	// Função que carrega o modal de impressão.
	$("a.modal-hist-trigger").click(function (event) {
		event.preventDefault();
		var a = $(this);
		$("#print-hist-prod").hide();
		historico = $.ajax({
			url: BASE_URL + 'index.php/clog/produtos/historico_produto',
			type: 'GET',
			dataType: 'html',
			data: {
				tombo: a.text()
			}
		});
		historico.done(function (result) {
			$("#modal-hist-content").empty();
			$("#modal-hist-content").html(result);
			$("#modal-hist-prod").modal('show');
		});
		imprime = $.ajax({
			url: BASE_URL + 'index.php/clog/produtos/imprime_historico_produto',
			type: 'GET',
			dataType: 'html',
			data: {
				tombo: a.text()
			}
		});
		imprime.done(function (result) {
			$("#print-hist-prod").empty();
			$("#print-hist-prod").html(result);
		});
	});

	$("#modal-hist-prod").on('hidden.bs.modal', function (e) {
		e.preventDefault();
		location.reload();
	});

	// Paginação
	$("#pagination").twbsPagination({
		first: '<<',
		prev: '<',
		next: '>',
		last: '>>',
		totalPages: $("#pagination").attr("data-total-pages"),
		visiblePages: 10,
		//href: BASE_URL + 'index.php/clog/filtrar_auditoria?page={{number}}',
		onPageClick: function (event, page) {
			dtIniVal = $("#data_inicial").val().split("/");
			dtIni = dtIniVal[2] + "-" + dtIniVal[1] + "-" + dtIniVal[0];
			// Tratando data final
			if ($("#data_final").val() == "") {
				dataHj = new Date();
				dHj = (dataHj.getDate() > 9) ? dataHj.getDate() : "0" + dataHj.getDate();
				mHj = ((dataHj.getMonth() + 1) > 9) ? (dataHj.getMonth() + 1) : "0" + (dataHj.getMonth() + 1);
				aHj = dataHj.getFullYear();
				$("#data_final").val(dHj + "/" + mHj + "/" + aHj);
				dtFim = aHj + "-" + mHj + "-" + dHj;
			}
			else {
				dtFimVal = $("#data_final").val().split("/");
				dtFim = dtFimVal[2] + "-" + dtFimVal[1] + "-" + dtFimVal[0];
			}
			event.preventDefault();
			audita = $.ajax({
				url: BASE_URL + 'index.php/clog/filtrar_auditoria?page=' + page,
				type: 'POST',
				dataType: 'html',
				data: {
					data_inicial: dtIni,
					data_final: dtFim,
					tipo_auditoria: $("#tipo_auditoria").val(),
					militares_id: $("#militares_id").val()
				}
			});
			audita.done(function (result) {
				$("#resultado_consulta").empty();
				$("#resultado_consulta").html(result);
			});
		}
	});

	// Sistema GBS
	$("#consulta-localidades").click(function (event) {
		consulta = $.ajax({
			url: BASE_URL + 'index.php/ocorrencias/locais/consulta_localidades/',
			type: 'GET',
			data: {
				cidade: $("#cidade").val()
			}
		});
			consulta.done(function (result) {
				$("#result-search").html(result);
			});
			consulta.fail(function () {
				alert('Consulta falhou, tente novamente mais tarde!');
			});
	});

	$("#consulta-ocorrencias").click(function (event) {
		alert("Clicou");
		consulta = $.ajax({
			url: BASE_URL + 'index.php/ocorrencias/consulta_ocorrencias/',
			type: 'GET',
			data: {
				data_inicio: $("input[name='data_inicio']").val(),
				data_fim: $("input[name='data_fim']").val(),
				idade: $("#idade").val(),
				localidade: $("#localidade").val(),
				tipo_ocorrencia: $("#tipo_ocorrencia").val(),
				quantidade_paginacao: $("#quantidade_paginacao").val()
			}
			});
			consulta.done(function (result) {
				$("#result-search").html(result);
			});
			consulta.fail(function (result) {
				alert('Consulta falhou, tente novamente mais tarde!');
		});
	}); //Ok! - Pereira

}); // Função Principal.

//MODAIS - Pereira

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
function confirmarDesativarTipoModelo(url) {
	$("#bt-modal-confirmar-desativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarTipoModelo(url) {
	$("#bt-modal-confirmar-reativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarDesativarTipoMarca(url) {
	$("#bt-modal-confirmar-desativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarTipoMarca(url) {
	$("#bt-modal-confirmar-reativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarDesativarTipoOdometro(url) {
	$("#bt-modal-confirmar-desativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarTipoOdometro(url) {
	$("#bt-modal-confirmar-reativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarDesativarTipoServico(url) {
	$("#bt-modal-confirmar-desativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarTipoServico(url) {
	$("#bt-modal-confirmar-reativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarDesativarTipoViatura(url) {
	$("#bt-modal-confirmar-desativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarReativarTipoViatura(url) {
	$("#bt-modal-confirmar-reativar").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarCancelarServico(url) {
	$("#bt-modal-confirmar-cancelar-servico").attr('href', url);
}

// Função que exibe Modal de confirmação.
function confirmarEntregaServico(urlEntrega) {
	$("#bt-modal-confirmar-entrega").attr('href', urlEntrega);
}

// Função que exibe Modal de confirmação.
function confirmarExcluirBoletim(url) {
	$("#bt-modal-confirmar-exclusao-boletim").attr('href', url);
}

// Obsoletos:
/*
	$("#select-tombo").change(function(event) {
	 if ($('#select-tombo').val() == 1) {
		$("#div_numero_tombo").show();
	 };
	}); 

	$("#consumo").change(function() {
		// Incluído por Pereira
		produtos = $.ajax({
			type: 'get',
			url: BASE_URL + 'index.php/clog/cautelas/getProdutos',
			dataType: 'json',
			data: {
			 consumo: $("#consumo").val(),
			}
		});
		produtos.done(function(result) {
			$("#produtos_cautela").empty();
			if (result.produtos.length > 0) {
				$("#produtos_cautela").append(new Option("Selecione", "2"));
				for (var i = result.produtos.length - 1; i >= 0; i--) {
					$("#produtos_cautela").append(new Option(result.produtos[i].modelo, result.produtos[i].id));
				}
			}
		});
		// .Pereira
		if($("#consumo").val() != 1) {
			$("#tombos_produto").empty();
			$("#tombos_produto").hide();
			$("#quantidade_tombos").find('input').remove();
			$("#quantidade_tombos_validacao").find('label').remove();
			$("#quantidade_tombos").find('br').remove();
			$("#tombamento").hide();
		}
		else {
			contador=1;
			$("#quantidade_input").val($("#quantidade_itens").val());
			while($("#quantidade_input").val() >= contador) {
				if($("#quantidade_input").val() >= contador) {
					$('<input class="form-control" name="numero_tombo'+contador+'" id="numero_tombo'+contador+'" placeholder="N° de Tombo '+contador+'" required /><br/>').appendTo("#quantidade_tombos");
					$('<label class="control-label" id="resultado_consulta_tombo"></label>').appendTo("#quantidade_tombos_validacao");
					$("#tombamento").show();
				}
				else {
				break;
				}
				contador++;
			}
		}
	});

	$("#quantidade_itens").focus(function(){
		$("#quantidade_tombos").find('input').remove();
		$("#quantidade_tombos_validacao").find('label').remove();
		//$("#produtos_cautela").each(function() {
		$("#produtos_cautela option[value='']").attr("selected", true);
		$("#consumo option[value='']").attr("selected", true);
		$("#quantidade_tombos").find('br').remove();
		$("#tombamento").hide();
	});
	//.input

	//Teste dos tombamentos
	$("#produtos_cautela").click(function(){
		contador = $("#quantidade_input").val();
		while(contador > 0) {
			$("#numero_tombo"+contador).keyup(function(){
				tombo = $(this).val();
				//alert($contador.val());
				if (tombo.length > 0) {
					//$produtos_id = $("#produtos_cautela").val();
					$.ajax({
						type: 'get',
						url: BASE_URL + 'index.php/clog/cautelas/validarTombo',
						dataType: 'json',
						data: {
							produto_id: $("#produtos_cautela").val(),
							tombo: tombo
						},
						success: function(result) {
							if (result.tombo != "") {
								if (result.tombo.cautela_id == undefined) {
									$("#resultado_consulta_tombo").html("Disponível");
								}
								else {
									if (result.tombo.finalizada == 0) {
										continuarCautela = BASE_URL + "index.php/clog/cautelas/mostrar?id=" + result.tombo.cautela_id;
										$("#resultado_consulta_tombo").html("Indisponível. Ver <a href= '"+ continuarCautela +"'>Cautela  n º " + result.tombo.cautela_id + "</a>");
									}
									else {
										$("#resultado_consulta_tombo").html("Indisponível.");
									}
								}
							}
							else {
								$("#resultado_consulta_tombo").html("Não encontrado");
							}
						}
					});
				}
			});
			contador--;
		}
	});
	//.teste
*/