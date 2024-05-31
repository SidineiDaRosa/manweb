
    window.onload = function() {
        let data_atual = new Date();
        var dia = String(data_atual.getDate()).padStart(2, '0');
        var mes = String(data_atual.getMonth() + 1).padStart(2, '0');
        var ano = data_atual.getFullYear();
        data_atual = ano + '-' + mes + '-' + dia;
        document.getElementById("data_emissao").value = data_atual;
        //!--javascript que mostra a hora atual no campo hora de emissão, que é atualizado a cada 1 segundo(1000ms)!-->

        // Função para formatar 1 em 01
        const zeroFill = n => {
            return ('0' + n).slice(-2);
        }
        // Cria intervalo
        const interval = setInterval(() => {
            // Pega o horário atual
            const now = new Date();

            // Formata a data conforme hh:mm
            const horaAtual = zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes());
            // Formata a data conforme aaaa-mm-dd

            document.getElementById('hora_emissao').value = horaAtual;
        }, 1000);


    }
    