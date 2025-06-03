<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
        <title>Área da Recepcionista</title>
        <style>
            body {
                background: linear-gradient(to bottom right, #f8f9fa, #d1d1d1);
            }
            .form-container {
                max-width: 700px;
                background-color: #2c2c2c;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 0 15px rgba(0,0,0,0.4);
                margin: 40px auto;
            }
            .form-label {
                font-weight: 500;
            }
            .form-control:focus, .form-select:focus {
                border-color: #dc3545;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }
            .titulo-principal a {
                text-decoration: none;
                color: #dc3545;
                font-weight: bold;
            }
            .form-heading {
                font-size: 26px;
                font-weight: bold;
                color: #ffffff;
                margin-bottom: 25px;
                text-align: center;
            }
            .form-heading i {
                margin-right: 10px;
                color: #dc3545;
            }
            .form-section {
                border-left: 4px solid #dc3545;
                padding-left: 15px;
                margin-bottom: 25px;
            }
            .btn-danger {
                font-weight: bold;
                letter-spacing: 0.5px;
            }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="fixer">
                <div class="titulo-container">
                    <h1 class="titulo-principal">
                        <a href="AreaDaRecepcionista.php">Hospital Vitalis</a>
                    </h1>
                </div>
                <hr class="border border-secondary border-2 opacity-50" style="margin-top: 0;" />
                <ul class="menu-acesso">
                    <li class="dropdown">
                        Opções
                        <ul class="submenu">
                            <li><a href="Perfis/PerfilRecepcionista.php" class="medico">Perfil</a></li>
                            <li><a href="AreaDaRecepcionista.php" class="recepcionista">Agendar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="form-container" style="margin-top: 125px;">
                <form action="../Controle/ControlePacientes.php?ACAO=cadastrarPaciente" method="POST">
                    <div class="form-heading">
                        <i class="fas fa-user-plus"></i> Cadastrar Paciente
                    </div>

                    <div class="form-section">
                        <div class="mb-3">
                            <label for="nome" class="form-label text-light">Nome:</label>
                            <input type="text" class="form-control" name="nome" id="nome" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-light">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="cpf" class="form-label text-light">CPF:</label>
                            <input type="text" class="form-control" name="cpf" id="cpf" maxlength="14" required>
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label text-light">Telefone:</label>
                            <input type="tel" class="form-control" name="telefone" id="telefone" maxlength="15" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="mb-3">
                            <label for="data_nascimento" class="form-label text-light">Data de Nascimento:</label>
                            <input type="date" class="form-control" name="data_nascimento" id="data_nascimento">
                        </div>

                        <div class="mb-3">
                            <label for="sexo" class="form-label text-light">Sexo:</label>
                            <select class="form-select" name="sexo" id="sexo">
                                <option value="">Selecione</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label text-light">Endereço:</label>
                            <input type="text" class="form-control" name="endereco" id="endereco" required>
                        </div>

                        <div class="mb-3">
                            <label for="cidade" class="form-label text-light">Cidade:</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" required>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label text-light">Estado (UF):</label>
                            <input type="text" class="form-control" name="estado" id="estado" maxlength="2" required>
                        </div>

                        <div class="mb-3">
                            <label for="cep" class="form-label text-light">CEP:</label>
                            <input type="text" class="form-control" name="cep" id="cep" maxlength="9" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="mb-4">
                            <label for="motivo" class="form-label text-light">Motivo da Consulta:</label>
                            <textarea class="form-control" name="motivo" id="motivo" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Cadastrar Paciente</button>
                    </div>
                </form>
            </div>
        </div>
        <footer class="side-footer">
            <div class="flex">
                <div class="endereco">
                    <h3>Fale Conosco</h3>
                    <div class="linha-info">
                        <h6>Telefone:</h6>
                        <p>(61)98923-9203</p>
                    </div>
                    <div class="linha-info">
                        <h6>E-mail:</h6>
                        <p>HospitalVitalis@gmail.com</p>
                    </div>
                    <div class="linha-info">
                        <h6>Atendimento:</h6>
                        <p>08h às 22h</p>
                    </div>
                    <div class="linha-info">
                        <h6>Emergência:</h6>
                        <p>24h todos os dias</p>
                    </div>
                </div>
                <hr class="footer-separator" />
                <div class="localizacao">
                    <h3>Localização</h3>
                    <p>Rua da Saúde, 123</p>
                    <p>Asa Norte - Brasília, DF</p>
                    <p>CEP: 70000-000</p>
                </div>
                <hr class="footer-separator" />
                <div class="especialidades">
                    <h3>Especialidades</h3>
                    <ul>
                        <li>Clínica Geral</li>
                        <li>Pediatria</li>
                        <li>Ortopedia</li>
                        <li>Ginecologia</li>
                        <li>Cardiologia</li>
                    </ul>
                </div>
                <hr class="footer-separator" />
                <div class="redes-sociais">
                    <h3>Redes sociais</h3>
                    <div class="rede">
                        <a href="https://facebook.com">
                            <img src="../Fotos/foto-facebook.webp" alt="Logo do Facebook" class="foto-icon" />
                            <span>Facebook</span>
                        </a>
                    </div>
                    <div class="rede">
                        <a href="https://instagram.com">
                            <img src="../Fotos/foto-instagram.png" alt="Logo do Instagram" class="foto-icon" />
                            <span>Instagram</span>
                        </a>
                    </div>
                    <div class="rede">
                        <a href="https://twitter.com">
                            <img src="../Fotos/foto-twitter.webp" alt="Logo do Twitter" class="foto-icon" />
                            <span>Twitter</span>
                        </a>
                    </div>
                    <div class="rede">
                        <a href="https://linkedin.com">
                            <img src="../Fotos/foto-linkedin.webp" alt="Logo do LinkedIn" class="foto-icon" />
                            <span>LinkedIn</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="termos">© 2025 Hospital Vitalis - Todos os direitos reservados</p>
            </div>
        </footer>
    </body>
</html>