@include('site.navigation_bar')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Preditiva e NRs</title>
    <style>
        :root {
            --primary-color: #2E7D32;
            --secondary-color: #4CAF50;
            --accent-color: #8BC34A;
            --light-color: #E8F5E9;
            --dark-color: #1B5E20;
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
        
        .tech-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 3px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .tech-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .tech-card h3 {
            color: var(--secondary-color);
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        
        .tech-card .tech-icon {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 3px;
            font-weight: bold;
            margin-right: 0.5rem;
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
        
        .comparison-table {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
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
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .benefit-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1.5rem;
            text-align: center;
        }
        
        .benefit-card h4 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .implementation-steps {
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
        
        .nr-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 3px rgba(0,0,0,0.05);
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
        
        .case-study {
            background-color: #E3F2FD;
            border-left: 4px solid #2196F3;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 0 5px 5px 0;
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
            
            .comparison-table {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Manutenção Preditiva e Normas Regulamentadoras</h1>
            <p>Tecnologia avançada para prever falhas e otimizar a manutenção</p>
        </div>
    </header>
    
    <nav>
        <div class="container">
            <ul>
                <li><a href="#introducao">Introdução</a></li>
                <li><a href="#o-que-e">O que é Manutenção Preditiva</a></li>
                <li><a href="#tecnicas">Técnicas</a></li>
                <li><a href="#vantagens">Vantagens</a></li>
                <li><a href="#nrs">NRs Aplicáveis</a></li>
                <li><a href="#implementacao">Implementação</a></li>
            </ul>
        </div>
    </nav>
    
    <main class="container">
        <section id="introducao">
            <h2>Introdução</h2>
            <p>A manutenção preditiva representa a evolução da gestão de ativos industriais, utilizando tecnologias avançadas para monitorar o estado dos equipamentos e prever falhas antes que ocorram. Esta abordagem proativa permite intervenções precisas no momento ideal, maximizando a disponibilidade e segurança dos equipamentos.</p>
            
            <div class="highlight">
                <p>A manutenção preditiva transforma a estratégia de manutenção de "corrigir quando quebra" para "intervir quando necessário", baseando-se em dados reais da condição do equipamento.</p>
            </div>
            
            <p>Este documento aborda os conceitos, técnicas, benefícios e requisitos normativos da manutenção preditiva, fornecendo um guia completo para sua implementação.</p>
        </section>
        
        <section id="o-que-e">
            <h2>O que é Manutenção Preditiva</h2>
            <p>Manutenção preditiva é uma estratégia que utiliza monitoramento contínuo ou periódico das condições dos equipamentos para identificar sinais precoces de falhas e programar intervenções antes que ocorram paradas não planejadas.</p>
            
            <h3>Princípios Fundamentais</h3>
            <ul>
                <li>Baseia-se na condição real do equipamento</li>
                <li>Utiliza tecnologias de monitoramento avançadas</li>
                <li>Permite intervenções no momento ideal</li>
                <li>Reduz intervenções desnecessárias</li>
                <li>Maximiza a vida útil dos componentes</li>
            </ul>
            
            <div class="comparison-table">
                <div class="comparison-column">
                    <h3>Preventiva</h3>
                    <ul>
                        <li>Baseada no tempo</li>
                        <li>Intervenções programadas</li>
                        <li>Pode substituir componentes bons</li>
                        <li>Custos previsíveis</li>
                        <li>Simples de implementar</li>
                    </ul>
                </div>
                <div class="comparison-column">
                    <h3>Corretiva</h3>
                    <ul>
                        <li>Reativa a falhas</li>
                        <li>Intervenções emergenciais</li>
                        <li>Alto custo de parada</li>
                        <li>Riscos de segurança</li>
                        <li>Imprevisível</li>
                    </ul>
                </div>
                <div class="comparison-column">
                    <h3>Preditiva</h3>
                    <ul>
                        <li>Baseada na condição</li>
                        <li>Intervenções no momento ideal</li>
                        <li>Minimiza substituições</li>
                        <li>Otimiza custos</li>
                        <li>Requiere tecnologia</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <section id="tecnicas">
            <h2>Técnicas de Manutenção Preditiva</h2>
            
            <div class="tech-card">
                <h3><span class="tech-icon">V</span>Análise de Vibração</h3>
                <p>Monitora as vibrações mecânicas para detectar desbalanceamento, desalinhamento, folgas e problemas em rolamentos.</p>
                <ul>
                    <li><strong>Aplicações:</strong> Motores, bombas, ventiladores, redutores</li>
                    <li><strong>Parâmetros:</strong> Velocidade, aceleração, deslocamento</li>
                    <li><strong>Vantagens:</strong> Detecção precoce de falhas mecânicas</li>
                    <li><strong>Limitações:</strong> Requer sensores especializados</li>
                </ul>
            </div>
            
            <div class="tech-card">
                <h3><span class="tech-icon">T</span>Termografia Infravermelha</h3>
                <p>Utiliza câmeras térmicas para detectar anomalias de temperatura em equipamentos e instalações elétricas.</p>
                <ul>
                    <li><strong>Aplicações:</strong> Painéis elétricos, transformadores, sistemas mecânicos</li>
                    <li><strong>Parâmetros:</strong> Temperatura superficial, gradientes térmicos</li>
                    <li><strong>Vantagens:</strong> Detecção de problemas elétricos e de isolamento</li>
                    <li><strong>Limitações:</strong> Requer linha de visada direta</li>
                </ul>
            </div>
            
            <div class="tech-card">
                <h3><span class="tech-icon">U</span>Ultrassom</h3>
                <p>Detecta sons em frequências ultrassônicas para identificar vazamentos, descargas elétricas e problemas em rolamentos.</p>
                <ul>
                    <li><strong>Aplicações:</strong> Vazamentos, descargas corona, análise de rolamentos</li>
                    <li><strong>Parâmetros:</strong> Intensidade ultrassônica, padrões de frequência</li>
                    <li><strong>Vantagens:</strong> Detecção precoce de problemas incipientes</li>
                    <li><strong>Limitações:</strong> Ambiente ruidoso pode interferir</li>
                </ul>
            </div>
            
            <div class="tech-card">
                <h3><span class="tech-icon">A</span>Análise de Óleo</h3>
                <p>Monitora a condição do lubrificante e partículas de desgaste para avaliar o estado interno dos equipamentos.</p>
                <ul>
                    <li><strong>Aplicações:</strong> Motores, sistemas hidráulicos, redutores</li>
                    <li><strong>Parâmetros:</strong> Viscosidade, contaminação, espectrometria</li>
                    <li><strong>Vantagens:</strong> Diagnóstico preciso do desgaste interno</li>
                    <li><strong>Limitações:</strong> Requer coleta e análise laboratorial</li>
                </ul>
            </div>
            
            <div class="tech-card">
                <h3><span class="tech-icon">C</span>Corrente Motor</h3>
                <p>Analisa a assinatura elétrica do motor para detectar problemas elétricos e mecânicos.</p>
                <ul>
                    <li><strong>Aplicações:</strong> Motores elétricos, bombas, ventiladores</li>
                    <li><strong>Parâmetros:</strong> Corrente, tensão, harmônicas</li>
                    <li><strong>Vantagens:</strong> Detecção de problemas no motor e carga acoplada</li>
                    <li><strong>Limitações:</strong> Requer conhecimento especializado</li>
                </ul>
            </div>
        </section>
        
        <section id="vantagens">
            <h2>Vantagens da Manutenção Preditiva</h2>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <h4>💰 Redução de Custos</h4>
                    <p>Minimiza paradas não planejadas e reduz substituições desnecessárias de componentes</p>
                </div>
                
                <div class="benefit-card">
                    <h4>🛡️ Melhoria na Segurança</h4>
                    <p>Prevê falhas potencialmente perigosas antes que ocorram</p>
                </div>
                
                <div class="benefit-card">
                    <h4>📈 Aumento da Disponibilidade</h4>
                    <p>Maximiza o tempo de operação dos equipamentos</p>
                </div>
                
                <div class="benefit-card">
                    <h4>🔧 Otimização de Recursos</h4>
                    <p>Permite melhor planejamento de mão de obra e materiais</p>
                </div>
                
                <div class="benefit-card">
                    <h4>📊 Dados para Decisão</h4>
                    <p>Fornece informações objetivas para tomada de decisão</p>
                </div>
                
                <div class="benefit-card">
                    <h4>🌱 Sustentabilidade</h4>
                    <p>Reduz consumo de energia e geração de resíduos</p>
                </div>
            </div>
            
            <h3>Impacto nos Indicadores de Manutenção</h3>
            <table>
                <thead>
                    <tr>
                        <th>Indicador</th>
                        <th>Manutenção Tradicional</th>
                        <th>Com Preditiva</th>
                        <th>Melhoria</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Disponibilidade</td>
                        <td>85-90%</td>
                        <td>95-98%</td>
                        <td>+10%</td>
                    </tr>
                    <tr>
                        <td>Custo de Manutenção/Receita</td>
                        <td>4-6%</td>
                        <td>2-3%</td>
                        <td>-50%</td>
                    </tr>
                    <tr>
                        <td>Manutenção Corretiva</td>
                        <td>40-50%</td>
                        <td>10-15%</td>
                        <td>-70%</td>
                    </tr>
                    <tr>
                        <td>Taxa de Falhas</td>
                        <td>Alta</td>
                        <td>Baixa</td>
                        <td>-60%</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        <section id="nrs">
            <h2>Normas Regulamentadoras Aplicáveis</h2>
            <p>A manutenção preditiva, embora tecnologicamente avançada, deve seguir as mesmas Normas Regulamentadoras que garantem a segurança dos trabalhadores durante as atividades de monitoramento e intervenção.</p>
            
            <div class="nr-card">
                <span class="nr-number">NR 10</span>
                <h3>Segurança em Instalações e Serviços em Eletricidade</h3>
                <p><strong>Aplicações em manutenção preditiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos para monitoramento de equipamentos elétricos energizados</li>
                    <li>Exige procedimentos para trabalho em proximidade de partes energizadas</li>
                    <li>Determina uso de EPIs específicos para medições elétricas</li>
                    <li>Exige capacitação para uso de equipamentos de medição</li>
                    <li>Estabelece procedimentos para análise termográfica</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 12</span>
                <h3>Segurança no Trabalho em Máquinas e Equipamentos</h3>
                <p><strong>Aplicações em manutenção preditiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos para monitoramento de máquinas em operação</li>
                    <li>Exige procedimentos seguros para coleta de dados em equipamentos móveis</li>
                    <li>Determina uso de proteções durante medições em partes móveis</li>
                    <li>Exige análise de risco para atividades de monitoramento</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 33</span>
                <h3>Segurança e Saúde em Trabalhos em Espaços Confinados</h3>
                <p><strong>Aplicações em manutenção preditiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos para monitoramento em espaços confinados</li>
                    <li>Exige Permissão de Entrada e Trabalho para coleta de dados</li>
                    <li>Determina monitoramento atmosférico contínuo</li>
                    <li>Exige procedimentos para uso de equipamentos em atmosferas explosivas</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 17</span>
                <h3>Ergonomia</h3>
                <p><strong>Aplicações em manutenção preditiva:</strong></p>
                <ul>
                    <li>Estabelece requisitos ergonômicos para uso de equipamentos de medição</li>
                    <li>Exige análise de posturas durante atividades de monitoramento</li>
                    <li>Determina limites para transporte de equipamentos de medição</li>
                    <li>Exige treinamento para técnicas de medição ergonômicas</li>
                </ul>
            </div>
        </section>
        
        <section id="implementacao">
            <h2>Implementação da Manutenção Preditiva</h2>
            
            <div class="implementation-steps">
                <div class="step">
                    <h3>Seleção de Equipamentos Críticos</h3>
                    <p>Identificar os equipamentos com maior impacto na produção, segurança e custos para priorizar a implementação.</p>
                </div>
                
                <div class="step">
                    <h3>Definição de Técnicas e Tecnologias</h3>
                    <p>Selecionar as técnicas preditivas mais adequadas para cada tipo de equipamento e modo de falha.</p>
                </div>
                
                <div class="step">
                    <h3>Aquisição de Equipamentos e Software</h3>
                    <p>Adquirir sensores, instrumentos de medição e sistemas de análise de dados adequados.</p>
                </div>
                
                <div class="step">
                    <h3>Capacitação da Equipe</h3>
                    <p>Treinar técnicos e engenheiros nas técnicas preditivas selecionadas e na interpretação de dados.</p>
                </div>
                
                <div class="step">
                    <h3>Estabelecimento de Linhas de Base</h3>
                    <p>Coletar dados iniciais para estabelecer condições de referência dos equipamentos.</p>
                </div>
                
                <div class="step">
                    <h3>Definição de Limites de Alerta</h3>
                    <p>Estabelecer valores limites que acionam alertas e ações corretivas.</p>
                </div>
                
                <div class="step">
                    <h3>Implementação de Rotinas de Coleta</h3>
                    <p>Criar programação regular para coleta de dados e monitoramento contínuo.</p>
                </div>
                
                <div class="step">
                    <h3>Integração com Sistemas de Gestão</h3>
                    <p>Conectar o programa preditivo ao sistema de gestão de manutenção existente.</p>
                </div>
            </div>
            
            <div class="case-study">
                <h3>📈 Estudo de Caso: Implementação em Usina Hidrelétrica</h3>
                <p><strong>Situação Inicial:</strong> Manutenção predominantemente preventiva com paradas programadas a cada 6 meses.</p>
                <p><strong>Solução Implementada:</strong> Monitoramento online de vibração em turbinas, análise de óleo em transformadores e termografia em painéis elétricos.</p>
                <p><strong>Resultados:</strong> Redução de 40% nas paradas não programadas, aumento de 15% na disponibilidade e economia de R$ 2,5 milhões/ano em custos de manutenção.</p>
            </div>
            
            <h3>Fatores Críticos de Sucesso</h3>
            <ul>
                <li><strong>Comprometimento da alta direção:</strong> Suporte para investimentos iniciais</li>
                <li><strong>Capacitação técnica:</strong> Equipe treinada e qualificada</li>
                <li><strong>Qualidade dos dados:</strong> Coleta consistente e confiável</li>
                <li><strong>Integração sistêmica:</strong> Conexão com outros sistemas de gestão</li>
                <li><strong>Melhoria contínua:</strong> Revisão constante de parâmetros e procedimentos</li>
            </ul>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>Documento informativo sobre Manutenção Preditiva e Normas Regulamentadoras</p>
            <p>Este material tem caráter informativo e não substitui a consulta às Normas Regulamentadoras completas.</p>
        </div>
    </footer>
</body>
</html>