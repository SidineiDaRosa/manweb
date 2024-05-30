//**************************************************************************************** */
//Grafico de gantt google charts
//**************************************************************************************** */
function executaTimeLine() {
    google.charts.load("current", { packages: ["timeline"] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var container = document.getElementById("timeline");
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();

        dataTable.addColumn({ type: "string", id: "codOs" });
        dataTable.addColumn({ type: "string", id: "nome" });
        dataTable.addColumn({ type: "datetime", id: "Inicio" });
        dataTable.addColumn({ type: "datetime", id: "Fim" });
        //-----------------------------------------------------------------------//
  
        table = document.getElementById("tblOs");
        for (var i = 1; i < table.rows.length; i++) {
            let codId =
                document.getElementById("tblOs").rows[i].cells[0].innerHTML; //id
            let patrimonio =
                document.getElementById("tblOs").rows[i].cells[5].innerHTML; //patrimonio
            let nome =
                document.getElementById("tblOs").rows[i].cells[9].innerHTML; //nome
            let descricao =
                document.getElementById("tblOs").rows[i].cells[11].innerHTML;
            let executado =
                document.getElementById("tblOs").rows[i].cells[12].innerHTML;
            let nomeExec = "ID:" + codId + "-Responsável:" + nome + "-Desc:" + descricao + "-Executado:" + executado;

            //data inicial
            let dataInic =
                document.getElementById("tblOs").rows[i].cells[3].innerHTML;
            //hora inicial
            let horaInic =
                document.getElementById("tblOs").rows[i].cells[4].innerHTML;

            //data final
            let dataFim =
                document.getElementById("tblOs").rows[i].cells[5].innerHTML;
            //hora final
            let horaFim =
                document.getElementById("tblOs").rows[i].cells[6].innerHTML;
            //União da data e hora de início
            let horaInicNew = new Date(dataInic + "T" + horaInic + "Z");
            let dataTimeInic = new Date(horaInicNew);

            dataTimeInic.setHours(horaInicNew.getHours() + 3);
            dataTimeInic.setMonth(horaInicNew.getMonth() + 1);
            //inicio pega datas e hora
            let anoInic = dataTimeInic.getUTCFullYear();
            //alert('ano:' + anoInic)
            let mesInic = dataTimeInic.getUTCMonth();
            // alert('mes:' + mesInic)
            let diaInic = dataTimeInic.getDate();
            //alert('dia:' + diaInic)
            let horaInicial = dataTimeInic.getHours();
            //alert('horas:' + horaInicial)
            let minutosInic = dataTimeInic.getUTCMinutes();
            //alert('minutos:' + minutosInic)
            let segundosInic = dataTimeInic.getSeconds();
            //alert('segundos:' + segundosInic)
            let horaAmericanaInic = dataTimeInic.toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            });
            //alert(horaAmericanaInic)

            //União da data e hora de

            let horaFimNew = new Date(dataFim + "T" + horaFim + "Z");

            let dataTimeFim = new Date(horaFimNew);
            dataTimeFim.setHours(horaFimNew.getHours() + 3);
            dataTimeFim.setMonth(horaFimNew.getMonth() + 1);
            let anoFin = dataTimeFim.getUTCFullYear();
            //alert('ano:' + ano)
            let mesFin = dataTimeFim.getUTCMonth();
            // alert('mes:' + mes)
            let diaFin = dataTimeFim.getDate();
            // alert('dia:' + dia)
            let horaFin = dataTimeFim.getHours();
            //alert('horas:' + hora3)
            let minFin = dataTimeFim.getUTCMinutes();
            // alert('minutos:' + minutos)
            let segFin = dataTimeFim.getSeconds();
            // alert('segundos:' + segundos)
            let horaAmericanaFim = dataTimeFim.toLocaleTimeString("en-US", {
                hour: "numeric",
                minute: "numeric",
                hour12: true,
            });
            // alert(horaAmericanaFim)
            //Gera linhas time line
            let dataTimeInicio =
                anoInic +
                "/0" +
                mesInic +
                "/" +
                diaInic +
                "," +
                horaInicial +
                ":" +
                minutosInic +
                ":" +
                segundosInic;

            //alert(dataTimeInicio)
            let dataTimeFinal =
                anoFin +
                "/0" +
                mesFin +
                "/" +
                diaFin +
                "," +
                horaFin +
                ":" +
                minFin +
                ":" +
                segFin;

            // alert(dataTimeFinal)
            dataTable.addRows([
                [
                    "ID:" + codId + "," + patrimonio,
                    nomeExec,
                    new Date(dataTimeInicio),
                    new Date(dataTimeFinal),
                ],
            ]);
            chart.draw(dataTable);
            //renderização de cores do timeline
            var options = {
                colors: ["#78f", "#5af", "#6af"],
                timeline: {
                    rowLabelStyle: {
                        fontName: "Arial sans-serif",
                        fontSize: 17,
                        color: "#000000",
                    },
                    barLabelStyle: { fontName: "Arial", fontSize: 15 },
                },
            };
            chart.draw(dataTable, options);

            //let dataInicFormat = (dataInicNew.getFullYear()) + "/" + (dataInicNew.getMonth() + 1) + "/" + (dataInicNew.getDate() + 1);
            //alert(dataFormatadaUTC.toUTCString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }))
            //let dataFormatadaUTC=dataFormatada

            //------------------------------------------------------------------------------//
            //Modelos de para mostrar dadta em formato americano
            // let dataFormatada =('T' + horaFim + 'Z');
            //let dataFormatada = (dataInicNew.getFullYear()) + "/" + (dataInicNew.getMonth()+1) + "/" + (dataInicNew.getDate());
            // (.toUTCString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }))
            //let data_brasileira = data_americana.split('-').reverse().join('/');
        }
    }
}