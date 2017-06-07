CREATE TABLE IF NOT EXISTS torcedor (
  codigo_torcedor INTEGER UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'PK',
  nome VARCHAR(35) NOT NULL COMMENT 'nome do torcedor',
  login VARCHAR(20) NOT NULL UNIQUE COMMENT 'login do torcedor',
  email VARCHAR(100) NOT NULL UNIQUE COMMENT 'email do torcedor',
  senha CHAR(128) NOT NULL COMMENT 'senha do torcedor',
  telefone VARCHAR(15) NOT NULL COMMENT 'telefone do torcedor',
  endereco VARCHAR(255) NOT NULL COMMENT 'endereço do torcedor',
  token CHAR(64) NULL COMMENT 'token de autenticacao do torcedor',
  otpsecret CHAR(16) NULL COMMENT 'Armazena a chave de autenticacao de 2 fatores do google autenticator',
  otpativado TINYINT(1) DEFAULT 0 NULL COMMENT 'flag que indica que autenticacao de 2 fatores foi ativada',
  PRIMARY KEY(codigo_torcedor) 
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT 'tabela que armazena os torcedores';

--dados fakes de teste para popular a tabela
INSERT INTO `torcedor` (`login`, `nome`, `email`, `telefone`, `endereco`) VALUES
('giovannamartins', 'Giovanna Lívia Eloá Martins', 'nina_sabrina@cantinadafazenda.com.br', '(61) 3588-2182', 'Quadra 305 Sul Rua 9'),
('catarinalima', 'Catarina Emily Lima', 'leticia.cecilia.cardoso@abcautoservice.net', '(61) 98716-3301', 'Rua B7'),
('emanuellydias', 'Emanuelly Fernanda Vitória Dias', 'emanuelly-fernanda96@artelazer.com', '(79) 3985-8357', 'Rua Carlos Alberto Villa Chan');
