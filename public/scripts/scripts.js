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
            url: "../index.php",
            dataType: "HTML",
            data: {
                horario_entrada: horario_entrada,
                horario_saida: horario_saida
            },
            success: (response) => {
                console.log(response)
            }
        })
    })
}