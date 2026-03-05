@include('site.navigation_bar')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção Preventiva e NRs</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
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
            background-color: var(--primary-color);
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
            background-color: var(--secondary-color);
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
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Manutenção Preventiva e Normas Regulamentadoras</h1>
            <p>Um guia completo sobre manutenção preventiva e as NRs aplicáveis</p>
        </div>
    </header>
    
    <nav>
        <div class="container">
            <ul>
                <li><a href="#introducao">Introdução</a></li>
                <li><a href="#o-que-e">O que é Manutenção Preventiva</a></li>
                <li><a href="#vantagens">Vantagens</a></li>
                <li><a href="#nrs">NRs Aplicáveis</a></li>
                <li><a href="#implementacao">Implementação</a></li>
            </ul>
        </div>
    </nav>
    
    <main class="container">
        <section id="introducao">
            <h2>Introdução</h2>
            <p>A manutenção preventiva é uma estratégia fundamental para garantir a segurança, eficiência e longevidade de equipamentos e instalações em ambientes industriais e comerciais. Este documento aborda os conceitos essenciais da manutenção preventiva e as Normas Regulamentadoras (NRs) que estabelecem os requisitos legais para sua implementação no Brasil.</p>
            
            <div class="highlight">
                <p>A manutenção preventiva não é apenas uma boa prática de gestão, mas também uma obrigação legal estabelecida por diversas Normas Regulamentadoras do Ministério do Trabalho e Emprego.</p>
            </div>
        </section>
        
        <section id="o-que-e">
            <h2>O que é Manutenção Preventiva</h2>
            <p>Manutenção preventiva consiste em um conjunto de atividades programadas e sistemáticas realizadas em equipamentos, máquinas e instalações com o objetivo de prevenir falhas, reduzir paradas não programadas e garantir o funcionamento seguro e eficiente.</p>
            
            <h3>Principais Características</h3>
            <ul>
                <li>É realizada de forma programada, com base em intervalos de tempo ou uso</li>
                <li>Foca na prevenção de falhas antes que ocorram</li>
                <li>Reduz custos com reparos emergenciais e paradas não programadas</li>
                <li>Aumenta a vida útil dos equipamentos</li>
                <li>Melhora a segurança do trabalho</li>
            </ul>
            
            <h3>Tipos de Manutenção Preventiva</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Exemplos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Baseada no Tempo</td>
                        <td>Realizada em intervalos de tempo fixos (horas, dias, meses)</td>
                        <td>Troca de óleo a cada 6 meses, lubrificação semestral</td>
                    </tr>
                    <tr>
                        <td>Baseada no Uso</td>
                        <td>Realizada após um determinado número de ciclos ou horas de operação</td>
                        <td>Manutenção após 1000 horas de operação, revisão a cada 10.000 ciclos</td>
                    </tr>
                    <tr>
                        <td>Preditiva</td>
                        <td>Utiliza monitoramento para prever quando a manutenção será necessária</td>
                        <td>Análise de vibração, termografia, análise de óleo</td>
                    </tr>
                </tbody>
            </table>
        </section>
        
        <section id="vantagens">
            <h2>Vantagens da Manutenção Preventiva</h2>
            
            <h3>Vantagens Operacionais</h3>
            <ul>
                <li>Redução de paradas não programadas</li>
                <li>Aumento da disponibilidade dos equipamentos</li>
                <li>Melhoria da qualidade do produto</li>
                <li>Redução do tempo de reparo</li>
                <li>Melhor planejamento de recursos</li>
            </ul>
            
            <h3>Vantagens Econômicas</h3>
            <ul>
                <li>Redução de custos com reparos emergenciais</li>
                <li>Aumento da vida útil dos equipamentos</li>
                <li>Redução de estoque de peças de reposição</li>
                <li>Melhoria da eficiência energética</li>
                <li>Redução de custos com seguros</li>
            </ul>
            
            <h3>Vantagens em Segurança</h3>
            <ul>
                <li>Redução de acidentes de trabalho</li>
                <li>Prevenção de falhas catastróficas</li>
                <li>Melhoria das condições de trabalho</li>
                <li>Conformidade com requisitos legais</li>
                <li>Redução de riscos ambientais</li>
            </ul>
        </section>
        
        <section id="nrs">
            <h2>Normas Regulamentadoras Aplicáveis</h2>
            <p>As Normas Regulamentadoras (NRs) estabelecem obrigações, direitos e deveres relativos à segurança e saúde no trabalho. Várias NRs tratam direta ou indiretamente da necessidade de manutenção preventiva.</p>
            
            <div class="nr-card">
                <span class="nr-number">NR 12</span>
                <h3>Segurança no Trabalho em Máquinas e Equipamentos</h3>
                <p><strong>Principais exigências relacionadas à manutenção preventiva:</strong></p>
                <ul>
                    <li>Estabelece a obrigatoriedade de manutenção periódica de máquinas e equipamentos</li>
                    <li>Exige que as máquinas possuam manual de instruções com procedimentos de manutenção</li>
                    <li>Determina a necessidade de capacitação dos trabalhadores envolvidos na manutenção</li>
                    <li>Estabelece requisitos para dispositivos de segurança e sua manutenção</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 10</span>
                <h3>Segurança em Instalações e Serviços em Eletricidade</h3>
                <p><strong>Principais exigências relacionadas à manutenção preventiva:</strong></p>
                <ul>
                    <li>Estabelece a necessidade de manutenção preventiva de instalações elétricas</li>
                    <li>Exige inspeções periódicas em instalações e equipamentos elétricos</li>
                    <li>Determina a manutenção de dispositivos de proteção</li>
                    <li>Estabelece procedimentos para manutenção em instalações energizadas</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 13</span>
                <h3>Caldeiras, Vasos de Pressão e Tubulações</h3>
                <p><strong>Principais exigências relacionadas à manutenção preventiva:</strong></p>
                <ul>
                    <li>Estabelece inspeções de segurança periódicas em caldeiras e vasos de pressão</li>
                    <li>Exige manutenção preventiva de dispositivos de segurança</li>
                    <li>Determina a elaboração de plano de manutenção preventiva</li>
                    <li>Estabelece requisitos para reparos e modificações</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 23</span>
                <h3>Proteção Contra Incêndios</h3>
                <p><strong>Principais exigências relacionadas à manutenção preventiva:</strong></p>
                <ul>
                    <li>Estabelece a necessidade de manutenção periódica de equipamentos de combate a incêndio</li>
                    <li>Exige inspeções regulares em sistemas de proteção contra incêndio</li>
                    <li>Determina a manutenção de saídas de emergência e rotas de fuga</li>
                    <li>Estabelece requisitos para manutenção de instalações elétricas para prevenção de incêndios</li>
                </ul>
            </div>
            
            <div class="nr-card">
                <span class="nr-number">NR 6</span>
                <h3>Equipamento de Proteção Individual - EPI</h3>
                <p><strong>Principais exigências relacionadas à manutenção preventiva:</strong></p>
                <ul>
                    <li>Estabelece a obrigatoriedade de higienização e manutenção de EPIs</li>
                    <li>Exige inspeções periódicas dos EPIs</li>
                    <li>Determina a substituição de EPIs danificados</li>
                    <li>Estabelece responsabilidades do empregador na manutenção dos EPIs</li>
                </ul>
            </div>
        </section>
        
        <section id="implementacao">
            <h2>Implementação de um Programa de Manutenção Preventiva</h2>
            
            <h3>Etapas para Implementação</h3>
            <ol>
                <li>
                    <strong>Inventário de Equipamentos:</strong>
                    <p>Identificar todos os equipamentos, máquinas e instalações que requerem manutenção preventiva, classificando-os por criticidade.</p>
                </li>
                <li>
                    <strong>Análise de Requisitos Legais:</strong>
                    <p>Identificar as NRs aplicáveis a cada equipamento e os requisitos específicos de manutenção.</p>
                </li>
                <li>
                    <strong>Elaboração de Procedimentos:</strong>
                    <p>Desenvolver procedimentos detalhados para cada tipo de manutenção preventiva, incluindo frequência, responsáveis e recursos necessários.</p>
                </li>
                <li>
                    <strong>Capacitação da Equipe:</strong>
                    <p>Treinar os colaboradores envolvidos na execução e supervisão da manutenção preventiva.</p>
                </li>
                <li>
                    <strong>Implantação do Sistema de Controle:</strong>
                    <p>Estabelecer um sistema para programar, executar, registrar e acompanhar as atividades de manutenção preventiva.</p>
                </li>
                <li>
                    <strong>Avaliação e Melhoria Contínua:</strong>
                    <p>Monitorar os resultados do programa e realizar ajustes para otimização.</p>
                </li>
            </ol>
            
            <h3>Documentação Necessária</h3>
            <ul>
                <li>Plano de Manutenção Preventiva</li>
                <li>Procedimentos Operacionais Padronizados (POPs)</li>
                <li>Planilhas de Controle e Registros</li>
                <li>Relatórios de Inspeção e Manutenção</li>
                <li>Laudos e Certificados de Conformidade</li>
                <li>Registros de Capacitação</li>
            </ul>
            
            <div class="highlight">
                <p>A implementação de um programa eficaz de manutenção preventiva não apenas atende aos requisitos legais das NRs, mas também contribui significativamente para a redução de custos, aumento da produtividade e melhoria do ambiente de trabalho.</p>
            </div>
        </section>
    </main>
    
    <footer>
        <div class="container">
            <p>Documento informativo sobre Manutenção Preventiva e Normas Regulamentadoras</p>
            <p>Este material tem caráter informativo e não substitui a consulta às Normas Regulamentadoras completas.</p>
        </div>
    </footer>
</body>
</html>