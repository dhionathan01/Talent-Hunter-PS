var j = jQuery.noConflict(); // Utilizar o var invés do let para que seja aplicado de forma global
j(document).ready(function () {
    console.log("Teste");
    buttonEnviarHorario();
})

const buttonEnviarHorario = () => {
    j('#enviarHorario').on('click', () => {
        let horario_entrada = j('#horario_entrada').val();
        let horario_saida = j('#horario_saida').val();
        console.log(horario_entrada);
        console.log(horario_saida);
        j.ajax({
            type: "POST",
            url: "../ajax/ajax_calcular.php",
            dataType: "HTML",
            data: {
                horario_entrada: horario_entrada,
                horario_saida: horario_saida
            },
            success: (response) => {
                 let objetoCalculo = JSON.parse(response);
                console.log(objetoCalculo);
                if (objetoCalculo.status == 'fail') {
                    renderMsg = `<div class="alert alert-danger">
                    <strong>Falha!</strong> A Data de Entrada Não pode ser maior que Saida.
                  </div>`; 
                  renderHtml = j('#msg').append(renderMsg); 

                    let horario_entrada = j('#horario_entrada').val('');
                    let horario_saida = j('#horario_saida').val('');
                    
                } else {
                    if (objetoCalculo.tempoCalculado.total_em_horas > 24) {
                        renderMsg = `<div class="alert alert-danger">
                            <strong>Falha!</strong> O Período não pode ultrapassar  24 horas.
                            </div>`; 
                        renderHtml = j('#msg').append(renderMsg); 
                    } else {
                        html = `
                            <div class="row">
                                <div   div class="col-md-3">${objetoCalculo.cabecalho.hora_inicio} </div>
                                <div class="col-md-3">${objetoCalculo.cabecalho.hora_fim} </div>
                                <div class="col-md-2">${objetoCalculo.tempoCalculado.total_em_horas}  Horas</div>
                                <div class="col-md-2">${objetoCalculo.diurno}H</div>
                                <div class="col-md-2">${objetoCalculo.noturno}H</div>
                            </div>`;
                        renderHtml = j('#registros_unitarios').append(html); 
                    }
                }
            }
        })
    })
}