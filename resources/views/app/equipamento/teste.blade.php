<!-- Mantém o mesmo bloco visual -->
<div style="padding: 30px; background: #f4f6f9; border-radius: 8px; margin: 20px; text-align: center; font-family: sans-serif;">
    <h3 style="color: #333; margin-bottom: 10px;">TESTE DE VIEW NOVA</h3>
    <div style="font-size: 32px; font-weight: bold; color: #2d3748;">
        Valor Atual: <span id="painel-telemetria" style="color: #3182ce;">Conectando...</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const baseUrl = window.location.origin;
        
        console.log('Abrindo conexão estável de tempo real absoluto...');

        // Abre um canal de transmissão contínuo com o Laravel
        const canalTempoReal = new EventSource(baseUrl + '/stream-telemetria');

        // Essa função roda sozinha no milissegundo exato em que o Laravel empurra o dado
        canalTempoReal.onmessage = function(event) {
            const resposta = JSON.parse(event.data);
            console.log("Dado empurrado pelo servidor na mesma hora:", resposta.dado);
            
            if (resposta.dado !== undefined) {
                document.getElementById('painel-telemetria').innerText = resposta.dado;
            }
        };

        canalTempoReal.onerror = function() {
            console.log("Aguardando sinal do ESP32...");
        };
    });
</script>
