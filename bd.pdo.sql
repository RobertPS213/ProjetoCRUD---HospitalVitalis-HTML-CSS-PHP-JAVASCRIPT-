CREATE DATABASE CRUD_PHP_PDO;
USE CRUD_PHP_PDO;

CREATE TABLE Recepcionista(
    ID INT AUTO_INCREMENT,
    Codigo INT UNIQUE NOT NULL,
    Nome VARCHAR(240) NOT NULL,
    Senha VARCHAR(60) NOT NULL,
    PRIMARY KEY(ID)
) ENGINE = InnoDB;

CREATE TABLE Medico(
    ID INT AUTO_INCREMENT,
    Matricula INT UNIQUE NOT NULL,
    Nome VARCHAR(240) NOT NULL,
    Senha VARCHAR(60) NOT NULL,
    PRIMARY KEY(ID)
) ENGINE = InnoDB;

CREATE TABLE Paciente(
    ID INT AUTO_INCREMENT,
    Nome VARCHAR(100),
    Email VARCHAR(60) NOT NULL UNIQUE,
    CPF VARCHAR(14) NOT NULL UNIQUE,
    Telefone VARCHAR(15) NOT NULL,
    DataDeNascimento DATE,
    Sexo ENUM('Masculino', 'Feminino'),
    Endereço VARCHAR(100) NOT NULL,
    Cidade VARCHAR(100) NOT NULL,
    Estado VARCHAR(2) NOT NULL,
    CEP VARCHAR(8) NOT NULL,
    MotivoDaConsulta VARCHAR(250) NOT NULL,
    DataCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ID_Medico INT,
    ID_Recepcionista INT,
    PRIMARY KEY(ID),
    FOREIGN KEY (ID_Medico) REFERENCES Medico(ID),
    FOREIGN KEY (ID_Recepcionista) REFERENCES Recepcionista(ID)
) ENGINE = InnoDB AUTO_INCREMENT=1;

/* INNER JOIN - MOSTRA A ID, NOME, DATA DE NASCIMENTO, TELEFONE DO PACIENTE, NOME DO MEDICO QUE ATENDEU O PACIENTE E NOME DO RECEPCIONISTA QUE ATENDEU O PACIENTE */

SELECT 
    p.ID AS ID_Paciente,
    p.Nome AS Nome_Paciente,
    p.DataDeNascimento,
    p.Telefone AS Telefone_Do_Paciente,
    m.Nome AS Nome_Medico,
    r.Nome AS Nome_Recepcionista
FROM Paciente p
LEFT JOIN Medico m ON p.ID_Medico = m.ID
LEFT JOIN Recepcionista r ON p.ID_Recepcionista = r.ID
ORDER BY p.DataCadastro DESC