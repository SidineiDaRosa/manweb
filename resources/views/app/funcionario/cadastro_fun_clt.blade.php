@extends('app.layouts.app')

@section('content')
<main class="content">

    <h2 style="margin-bottom: 20px;">Cadastrar Novo Funcionário</h2>

    <a href="{{ route('funcionarios.index') }}"
        style="padding: 8px 14px; background: #6c757d; color: white; 
               text-decoration: none; border-radius: 5px; margin-bottom: 20px;">
        ← Voltar para Lista
    </a>

    <form action="{{ route('funcionarios.store') }}" method="POST" 
          style="width:100%; max-width:800px; background:#f8f9fa; 
                 padding:25px; border-radius:8px; border:1px solid #ccc;">

        @csrf

        {{-- Seção 1: Dados Pessoais Obrigatórios --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
                ⚠️ DADOS PESSOAIS (OBRIGATÓRIOS POR LEI)
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="nome_completo" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Nome Completo *
                    </label>
                    <input type="text" name="nome_completo" id="nome_completo"
                           value="{{ old('nome_completo') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="cpf" style="display:block; margin-bottom:5px; font-weight:bold;">
                        CPF *
                    </label>
                    <input type="text" name="cpf" id="cpf" 
                           value="{{ old('cpf') }}"
                           placeholder="000.000.000-00"
                           pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="data_nascimento" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Data de Nascimento *
                    </label>
                    <input type="date" name="data_nascimento" id="data_nascimento"
                           value="{{ old('data_nascimento') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="rg" style="display:block; margin-bottom:5px; font-weight:bold;">
                        RG *
                    </label>
                    <input type="text" name="rg" id="rg"
                           value="{{ old('rg') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="orgao_emissor" style="display:block; margin-bottom:5px;">
                        Órgão Emissor *
                    </label>
                    <input type="text" name="orgao_emissor" id="orgao_emissor"
                           value="{{ old('orgao_emissor') }}"
                           placeholder="Ex: SSP-SP"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="data_emissao_rg" style="display:block; margin-bottom:5px;">
                        Data Emissão RG *
                    </label>
                    <input type="date" name="data_emissao_rg" id="data_emissao_rg"
                           value="{{ old('data_emissao_rg') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>
            </div>
        </div>

        {{-- Seção 2: Documentos Trabalhistas --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
                📄 DOCUMENTOS TRABALHISTAS (OBRIGATÓRIOS)
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="ctps" style="display:block; margin-bottom:5px; font-weight:bold;">
                        CTPS (Número) *
                    </label>
                    <input type="text" name="ctps" id="ctps"
                           value="{{ old('ctps') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="serie_ctps" style="display:block; margin-bottom:5px;">
                        Série CTPS *
                    </label>
                    <input type="text" name="serie_ctps" id="serie_ctps"
                           value="{{ old('serie_ctps') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="pis" style="display:block; margin-bottom:5px; font-weight:bold;">
                        PIS/PASEP *
                    </label>
                    <input type="text" name="pis" id="pis"
                           value="{{ old('pis') }}"
                           placeholder="000.00000.00-0"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="titulo_eleitor" style="display:block; margin-bottom:5px;">
                        Título de Eleitor *
                    </label>
                    <input type="text" name="titulo_eleitor" id="titulo_eleitor"
                           value="{{ old('titulo_eleitor') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="reservista" style="display:block; margin-bottom:5px;">
                        Certificado Reservista (se homem)
                    </label>
                    <input type="text" name="reservista" id="reservista"
                           value="{{ old('reservista') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>

                <div>
                    <label for="escolaridade" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Escolaridade *
                    </label>
                    <select name="escolaridade" id="escolaridade"
                            style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                            required>
                        <option value="">Selecione</option>
                        <option value="fundamental_incompleto">Fundamental Incompleto</option>
                        <option value="fundamental_completo">Fundamental Completo</option>
                        <option value="medio_incompleto">Médio Incompleto</option>
                        <option value="medio_completo">Médio Completo</option>
                        <option value="superior_incompleto">Superior Incompleto</option>
                        <option value="superior_completo">Superior Completo</option>
                        <option value="pos_graduacao">Pós-Graduação</option>
                        <option value="mestrado">Mestrado</option>
                        <option value="doutorado">Doutorado</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Seção 3: Dados Contratuais --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3 style="color: #dc3545; border-bottom: 2px solid #dc3545; padding-bottom: 10px;">
                📝 DADOS CONTRATUAIS (OBRIGATÓRIOS)
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="data_admissao" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Data de Admissão *
                    </label>
                    <input type="date" name="data_admissao" id="data_admissao"
                           value="{{ old('data_admissao', date('Y-m-d')) }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="cargo" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Cargo/Função *
                    </label>
                    <input type="text" name="cargo" id="cargo"
                           value="{{ old('cargo') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="salario" style="display:block; margin-bottom:5px; font-weight:bold;">
                        Salário Base (R$) *
                    </label>
                    <input type="number" name="salario" id="salario" step="0.01" min="0"
                           value="{{ old('salario') }}"
                           placeholder="0,00"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="cbo" style="display:block; margin-bottom:5px;">
                        CBO (Código) *
                    </label>
                    <input type="text" name="cbo" id="cbo"
                           value="{{ old('cbo') }}"
                           placeholder="Ex: 2522-05"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="jornada_semanal" style="display:block; margin-bottom:5px;">
                        Jornada Semanal (horas) *
                    </label>
                    <input type="number" name="jornada_semanal" id="jornada_semanal"
                           value="{{ old('jornada_semanal', 44) }}"
                           min="1" max="44"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="horario_trabalho" style="display:block; margin-bottom:5px;">
                        Horário de Trabalho *
                    </label>
                    <input type="text" name="horario_trabalho" id="horario_trabalho"
                           value="{{ old('horario_trabalho') }}"
                           placeholder="Ex: 08:00 às 17:00"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>
            </div>
        </div>

        {{-- Seção 4: Contato e Endereço --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3>📞 CONTATO E ENDEREÇO</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="telefone" style="display:block; margin-bottom:5px;">
                        Telefone *
                    </label>
                    <input type="tel" name="telefone" id="telefone"
                           value="{{ old('telefone') }}"
                           placeholder="(11) 99999-9999"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="email" style="display:block; margin-bottom:5px;">
                        E-mail *
                    </label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="cep" style="display:block; margin-bottom:5px;">
                        CEP *
                    </label>
                    <input type="text" name="cep" id="cep"
                           value="{{ old('cep') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="endereco" style="display:block; margin-bottom:5px;">
                        Endereço *
                    </label>
                    <input type="text" name="endereco" id="endereco"
                           value="{{ old('endereco') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="numero" style="display:block; margin-bottom:5px;">
                        Número *
                    </label>
                    <input type="text" name="numero" id="numero"
                           value="{{ old('numero') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="complemento" style="display:block; margin-bottom:5px;">
                        Complemento
                    </label>
                    <input type="text" name="complemento" id="complemento"
                           value="{{ old('complemento') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                </div>
            </div>
        </div>

        {{-- Seção 5: Informações Bancárias --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3>🏦 INFORMAÇÕES BANCÁRIAS (PARA PAGAMENTO)</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="banco" style="display:block; margin-bottom:5px;">
                        Banco *
                    </label>
                    <select name="banco" id="banco"
                            style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                            required>
                        <option value="">Selecione o banco</option>
                        <option value="001">Banco do Brasil</option>
                        <option value="033">Santander</option>
                        <option value="104">Caixa Econômica</option>
                        <option value="237">Bradesco</option>
                        <option value="341">Itaú</option>
                        <option value="356">Banco Real</option>
                    </select>
                </div>

                <div>
                    <label for="agencia" style="display:block; margin-bottom:5px;">
                        Agência *
                    </label>
                    <input type="text" name="agencia" id="agencia"
                           value="{{ old('agencia') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="conta" style="display:block; margin-bottom:5px;">
                        Conta Corrente *
                    </label>
                    <input type="text" name="conta" id="conta"
                           value="{{ old('conta') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="tipo_conta" style="display:block; margin-bottom:5px;">
                        Tipo de Conta *
                    </label>
                    <select name="tipo_conta" id="tipo_conta"
                            style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                            required>
                        <option value="corrente">Conta Corrente</option>
                        <option value="poupanca">Conta Poupança</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Seção 6: Contato de Emergência --}}
        <div style="background: white; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3>🚨 CONTATO DE EMERGÊNCIA</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label for="contato_emergencia_nome" style="display:block; margin-bottom:5px;">
                        Nome do Contato *
                    </label>
                    <input type="text" name="contato_emergencia_nome" id="contato_emergencia_nome"
                           value="{{ old('contato_emergencia_nome') }}"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="contato_emergencia_telefone" style="display:block; margin-bottom:5px;">
                        Telefone do Contato *
                    </label>
                    <input type="tel" name="contato_emergencia_telefone" id="contato_emergencia_telefone"
                           value="{{ old('contato_emergencia_telefone') }}"
                           placeholder="(11) 99999-9999"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>

                <div>
                    <label for="contato_emergencia_parentesco" style="display:block; margin-bottom:5px;">
                        Parentesco *
                    </label>
                    <input type="text" name="contato_emergencia_parentesco" id="contato_emergencia_parentesco"
                           value="{{ old('contato_emergencia_parentesco') }}"
                           placeholder="Ex: Mãe, Pai, Cônjuge"
                           style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;"
                           required>
                </div>
            </div>
        </div>

        {{-- Aviso Legal --}}
        <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; 
                    border-radius: 5px; margin-bottom: 20px;">
            <h4 style="color: #856404; margin-top: 0;">
                ⚠️ AVISO LEGAL IMPORTANTE
            </h4>
            <p style="margin: 0; font-size: 0.9em; color: #856404;">
                Este formulário coleta dados pessoais sensíveis. 
                A empresa está obrigada pela <strong>LGPD (Lei 13.709/2018)</strong> 
                a proteger essas informações. Todos os campos marcados com * são 
                obrigatórios por lei trabalhista (CLT) e para fins de eSocial.
            </p>
        </div>

        {{-- Botões de Ação --}}
        <div style="text-align: center; margin-top: 25px;">
            <button type="submit"
                    style="padding: 12px 30px; background: #28a745; color: white; 
                           border: none; border-radius: 5px; cursor: pointer;
                           font-size: 1.1em; font-weight: bold; margin-right: 15px;">
                ✅ Cadastrar Funcionário
            </button>
            
            <a href="{{ route('funcionarios.index') }}"
               style="padding: 10px 25px; background: #6c757d; color: white; 
                      text-decoration: none; border-radius: 5px; display: inline-block;">
                Cancelar
            </a>
        </div>

    </form>

    {{-- JavaScript para máscaras --}}
    <script>
        // Máscaras para CPF, Telefone, etc.
        document.addEventListener('DOMContentLoaded', function() {
            // Máscara para CPF
            var cpf = document.getElementById('cpf');
            if (cpf) {
                cpf.addEventListener('input', function(e) {
                    var value = e.target.value.replace(/\D/g, '');
                    if (value.length > 3 && value.length <= 6) {
                        value = value.replace(/^(\d{3})(\d+)/, '$1.$2');
                    } else if (value.length > 6 && value.length <= 9) {
                        value = value.replace(/^(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
                    } else if (value.length > 9) {
                        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d+)/, '$1.$2.$3-$4');
                    }
                    e.target.value = value;
                });
            }

            // Máscara para Telefone
            var telefone = document.getElementById('telefone');
            if (telefone) {
                telefone.addEventListener('input', function(e) {
                    var value = e.target.value.replace(/\D/g, '');
                    if (value.length > 2 && value.length <= 6) {
                        value = value.replace(/^(\d{2})(\d+)/, '($1) $2');
                    } else if (value.length > 6 && value.length <= 10) {
                        value = value.replace(/^(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
                    } else if (value.length > 10) {
                        value = value.replace(/^(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
                    }
                    e.target.value = value;
                });
            }

            // Máscara para CEP
            var cep = document.getElementById('cep');
            if (cep) {
                cep.addEventListener('input', function(e) {
                    var value = e.target.value.replace(/\D/g, '');
                    if (value.length > 5) {
                        value = value.replace(/^(\d{5})(\d+)/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }
        });
    </script>

</main>
@endsection