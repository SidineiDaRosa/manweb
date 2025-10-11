@include('site.navigation_bar')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Corretiva e NRs</title>
    <style>
        :root {
            --primary-color: #8B0000;
            --secondary-color: #B22222;
            --accent-color: #DC143C;
            --light-color: #FFE4E1;
            --dark-color: #660000;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        header h1 {
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
        }
        
        header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        nav {
            background-color: var(--dark-color);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            flex-wrap: wrap;
        }
        
        nav li {
            margin: 0;
        }
        
        nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 1rem 1.5rem;
            transition: background-color 0.3s;
        }
        
        nav a:hover {
            background-color: var(--accent-color);
        }
        
        main {
            padding: 2rem 0;
        }
        
        section {
            background-color: white;
            margin-bottom: 2rem;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--light-color);
        }
        
        h3 {
            color: var(--dark-color);
            margin: 1.5rem 0 1rem 0;
        }
        
        p {
            margin-bottom: 1rem;
        }
        
        ul, ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }
        
        li {
            margin-bottom: 0.5rem;
        }
        
        .highlight {
            background-color: var(--light-color);
            padding: 1.5rem;
            border-left: 4px solid var(--secondary-color);
            margin: 1.5rem 0;
            border-radius: 0 5px 5px 0;
        }
        
        .warning {
            background-color: #FFF3CD;
            border-left: 4px solid #FFC107;
            color: #856404;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 5px 5px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: var(--light-color);
            color: var(--primary-color);
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .nr-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 3px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .nr-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .nr-card h3 {
            color: var(--secondary-color);
            margin-top: 0;
        }
        
        .nr-card .nr-number {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .comparison-table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .comparison-column {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1.5rem;
        }
        
        .comparison-column h3 {
            text-align: center;
            margin-top: 0;
        }
        
        .pros-cons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .pros, .cons {
            padding: 1.5rem;
            border-radius: 5px;
        }
        
        .pros {
            background-color: #f0f9ff;
            border-left: 4px solid #4CAF50;
        }
        
        .cons {
            background-color: #fff5f5;
            border-left: 4px solid #f44336;
        }
        
        .step-by-step {
            counter-reset: step-counter;
            margin: 1.5rem 0;
        }
        
        .step {
            position: relative;
            padding-left: 3rem;
            margin-bottom: 1.5rem;
        }
        
        .step:before {
            counter-increment: step-counter;
            content: counter(step-counter);
            position: absolute;
            left: 0;
            top: 0;
            background-color: var(--primary-color);
            color: white;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 2rem;
        }
        
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }
            
            nav a {
                text-align: center;
            }
            
            section {
                padding: 1.5rem;
            }
            
            .comparison-table, .pros-cons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Manutenção Corretiva e Normas Regulamentadoras</h1>
            <p>Gestão de reparos emergenciais e as NRs aplicáveis</p>
        </div>
    </header>
    
    <nav>
        <div class="container">
            <ul>
                <li><a href="#introducao">Introdução</a></li>
                <li><a href="#o-que-e">O que é Manutenção Corretiva</a></li>
                <li><a href="#tipos">Tipos</a></li>
                <li><a href="#vantagens-desvantagens">Vantagens e Desvantagens</a></li>
                <li><a href="#nrs">NRs Aplicáveis</a></li>
                <li><a href="#procedimentos">Procedimentos Seguros</a></li>
            </ul>
        </div>
    </nav>
    
    <main class="container">
        <section id="introducao">
            <h2>Introdução</h2>
            <p>A manutenção corretiva é uma abordagem reativa para reparo de equipamentos e instalações, realizada após a ocorrência de uma falha ou quebra. Embora não seja a estratégia ideal, é uma realidade em muitos ambientes industriais e requer procedimentos específicos para garantir a segurança dos trabalhadores.</p>
            
            <div class="warning">
                <p>A manutenção corretiva frequentemente envolve situações de risco aumentado, exigindo atenção especial aos procedimentos de segurança e às Normas Regulamentadoras aplicáveis.</p>
            </div>
            
            <p>Este documento aborda os conceitos da manutenção corretiva, seus diferentes tipos, as NRs relevantes e os procedimentos seguros para sua execução.</p>
        </section>
        
        <section id="o-que-e">
            <h2>O que é Manutenção Corretiva</h2>
            <p>Manutenção corretiva consiste em todas as ações realizadas para restaurar um item com defeito a um estado em que possa executar sua função requerida. Diferente da manutenção preventiva, ela é executada após a falha ter ocorrido.</p>
            
            <h3>Características Principais</h3>
            <ul>
                <li>É reativa - responde a falhas já ocorridas</li>
                <li>Não é programada - ocorre de forma imprevista</li>
                <li>Objetiva restaurar a funcionalidade do equipamento</li>
                <li>Pode ser emergencial ou não emergencial</li>
                <li>Frequentemente envolve reparos não planejados</li>
            </ul>
            
            <div class="comparison-table">
                <div class="comparison-column">
                    <h3>Manutenção Corretiva</h3>
                    <ul>
                        <li>Executada após a falha</li>
                        <li>Não programada</li>
                        <li>Reativa</li>
                        <li>Pode causar paradas prolongadas</li>
                        <li>Custos imprevistos</li>
                    </ul>
                </div>
                <div class="comparison-column">
                    <h3>Manutenção Preventiva</h3>
                    <ul>
                        <li>Executada antes da falha</li>
                        <li>Programada</li>
                        <li>Proativa</li>
                        <li>Paradas planejadas</li>
                        <li>Custos previstos</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <section id="tipos">
            <h2>Tipos de Manutenção Corretiva</h2>
            
            <h3>Manutenção Corretiva Imediata (Emergencial)</h3>
            <p>Realizada imediatamente após a falha, quando o equipamento é crítico para a operação ou representa risco à segurança.</p>
            <ul>
                <li>Reparos em equipamentos de proteção coletiva danificados</li>
                <li>Correção de vazamentos perigosos</li>
                <li>Reparo de falhas elétricas que representam risco</li>
                <li>Correção de problemas em sistemas de emergência</li>
            </ul>
            
            <h3>Manutenção Corretiva Diferida (Planejada)</h3>
            <p>Quando a falha não é crítica, o reparo pode ser agendado para um momento mais conveniente.</p>
            <ul>
                <li>Reparo de equipamentos de backup</li>
                <li>Falhas em sistemas não críticos</li>
                <li>Equipamentos com redundância</li>
                <li>Problemas que não afetam a segurança ou produção</li>
            </ul>
            
            <div class="highlight">
                <p>A manutenção corretiva diferida permite melhor planejamento, alocação de recursos e execução mais segura, sendo preferível sempre que possível.</p>
            </div>
        </section>
        
        <section id="vantagens-desvantagens">
            <h2>Vantagens e Desvantagens</h2>
            
            <div class="pros-cons">
                <div class="pros">
                    <h3>Vantagens</h3>
                    <ul>
                        <li>Menor custo inicial (não requer investimento em prevenção)</li>
                        <li>Simplicidade de implementação</li>
                        <li>Não requer planejamento complexo</li>
                        <li>Adequada para equipamentos não críticos</li>
                        <li>Utilização máxima da vida útil do componente</li>
                    </ul>
                </div>
                
                <div class="cons">
                    <h3>Desvantagens</h3>
                    <ul>
                        <li>Paradas não planejadas e prolongadas</li>
                        <li>Maior custo total no longo prazo</li>
                        <li>Risco aumentado de acidentes</li>
                        <li>Dificuldade de planejamento de recursos</li>
                        <li>Possibilidade de danos secundários</li>
                        <li>Impacto na produtividade</li>
                    </ul>
                </div>
            </div>
            
            <div class="warning">
                <p>A manutenção corretiva emergencial apresenta riscos significativamente maiores à segurança dos trabalhadores, exigindo procedimentos rigorosos e atenção especial às NRs aplicáveis.</p>
            </div>
        </section>
        
        <section id="nrs">
            <h2>Normas Regulamentadoras Aplicáveis</h2>
            <p>As Normas Regulamentadoras estabelecem requisitos específicos para situações de manutenção corretiva, especialmente quando envolvem riscos à segurança e saúde dos trabalhadores.</p>
            
            <div class="nr-card">
                <span class="nr-number">NR 10</span>
                <h3>Segurança em Instalações e Serviços em Eletricidade</h3>
                <p><strong>Aplicações em manutenção corretiva:</strong></p>
                <ul>
                    <li>Estabelece procedimentos para manutenção corretiva em instalações elétricas</li>
                    <li>Exige análise de risco antes da intervenção</li>
                    <li>Determina a necessidade de desenergização ou trabalho em tensão com procedimentos específicos</li>
                    <li>Exige capacitação específica para trabalhadores</li>
                    <li>Estabelece uso de EPIs e EPCs adequados</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 12</span>
                <h3>Segurança no Trabalho em Máquinas e Equipamentos</h3>
                <p><strong>Aplicações em manutenção corretiva:</strong></p>
                <ul>
                    <li>Estabelece procedimentos para manutenção corretiva em máquinas</li>
                    <li>Exige bloqueio e etiquetagem (LOTO - Lockout Tagout) durante reparos</li>
                    <li>Determina a necessidade de teste dos dispositivos de segurança após reparo</li>
                    <li>Exige capacitação específica para manutenção corretiva</li>
                    <li>Estabelece procedimentos para substituição de componentes de segurança</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 33</span>
                <h3>Segurança e Saúde em Trabalhos em Espaços Confinados</h3>
                <p><strong>Aplicações em manutenção corretiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos para manutenção corretiva em espaços confinados</li>
                    <li>Exige Permissão de Entrada e Trabalho (PET)</li>
                    <li>Determina monitoramento contínuo da atmosfera</li>
                    <li>Exige supervisão permanente por vigia treinado</li>
                    <li>Estabelece procedimentos de emergência e resgate</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 35</span>
                <h3>Trabalho em Altura</h3>
                <p><strong>Aplicações em manutenção corretiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos para manutenção corretiva em altura</li>
                    <li>Exige Análise de Risco (AR) e Permissão de Trabalho (PT)</li>
                    <li>Determina uso de sistemas de proteção contra quedas</li>
                    <li>Exige inspeção dos equipamentos antes do uso</li>
                    <li>Estabelece procedimentos para trabalho em telhados e estruturas elevadas</li>
                </ul>
            </div>
        </section>
        
        <section id="procedimentos">
            <h2>Procedimentos Seguros para Manutenção Corretiva</h2>
            
            <div class="step-by-step">
                <div class="step">
                    <h3>Identificação e Avaliação da Falha</h3>
                    <p>Analisar a natureza da falha, seus impactos e os riscos envolvidos. Determinar se o reparo é emergencial ou pode ser programado.</p>
                </div>
                
                <div class="step">
                    <h3>Isolamento e Bloqueio</h3>
                    <p>Isolar a área e bloquear o equipamento conforme procedimentos LOTO (Lockout Tagout) para garantir que não haja energização acidental durante o reparo.</p>
                </div>
                
                <div class="step">
                    <h3>Análise de Riscos</h3>
                    <p>Identificar todos os riscos envolvidos na atividade: elétricos, mecânicos, químicos, altura, espaços confinados, etc.</p>
                </div>
                
                <div class="step">
                    <h3>Emissão de Permissão de Trabalho</h3>
                    <p>Quando aplicável, emitir Permissão de Trabalho específica para a atividade, detalhando os riscos e medidas de controle.</p>
                </div>
                
                <div class="step">
                    <h3>Seleção de EPIs e EPCs</h3>
                    <p>Selecionar e disponibilizar os Equipamentos de Proteção Individual e Coletiva adequados aos riscos identificados.</p>
                </div>
                
                <div class="step">
                    <h3>Execução do Reparo</h3>
                    <p>Realizar o reparo seguindo os procedimentos estabelecidos, com supervisão quando necessário.</p>
                </div>
                
                <div class="step">
                    <h3>Testes e Verificação</h3>
                    <p>Após o reparo, realizar testes para verificar a funcionalidade e segurança do equipamento.</p>
                </div>
                
                <div class="step">
                    <h3>Retorno à Operação</h3>
                    <p>Remover bloqueios e etiquetas, comunicar o retorno à operação e registrar a atividade de manutenção.</p>
                </div>
            </div>
            
            <div class="highlight">
                <p>Todo procedimento de manutenção corretiva deve ser documentado, incluindo a falha identificada, reparo realizado, peças substituídas e testes realizados. Esta documentação é essencial para análise de causas e melhoria contínua.</p>
            </div>
            
            <h3>Registros Obrigatórios</h3>
            <ul>
                <li>Ordem de Serviço ou Solicitação de Manutenção</li>
                <li>Análise de Risco da atividade</li>
                <li>Permissão de Trabalho (quando aplicável)</li>
                <li>Checklist de Bloqueio e Etiquetagem (LOTO)</li>
                <li>Registro de Testes Pós-Reparo</li>
                <li>Relatório de Manutenção com peças utilizadas</li>
            </ul>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>Documento informativo sobre Manutenção Corretiva e Normas Regulamentadoras</p>
            <p>Este material tem caráter informativo e não substitui a consulta às Normas Regulamentadoras completas.</p>
        </div>
    </footer>
</body>
</html>