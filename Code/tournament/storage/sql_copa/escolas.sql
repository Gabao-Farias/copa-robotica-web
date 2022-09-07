/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.1.46-log 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `` (
	`cod_escola` int ,
	`nome_escola` varchar ,
	`end` varchar ,
	`bairro` varchar ,
	`cidade` varchar ,
	`uf` varchar ,
	`fone` varchar ,
	`cep` varchar ,
	`diretor` varchar ,
	`evento` varchar ,
	`qtd_equipes` int 
); 
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('26','COLÉGIO ESTADUAL MISSÕES','RUA BARÃO DO TRIUNFO, 264','','SANTO ÂNGELO','','(55)3312-1992','','','copa_robotica2016|R-40','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('27','Colégio Tiradentes','rua Antunes Ribas, 2937','','Santo Ângelo','','(55)3313-2508','','','copa_robotica2016|R-38','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('29','INSTITUTO ESTADUAL RUI BARBOSA','RUA BORGES DE MEDEIROS - 2810','','SÃO LUIZ GONZAGA','','(55)3352-5999','','','copa_robotica2016|R-54','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('38','ESCOLA TÉCNICA TÉCNICA ESTADUAL PRESIDENTE GETÚLIO VARGAS','AV.GETÚLIO VARGAS 1116','','SANTO ÂNGELO','','(55)3312-1463','','','copa_robotica2016|R-72','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('30','Escola de Educação Básica da URI - Santo Ângelo','Rua Universidade das Missões, 464','','Santo Ângelo','','(55)3313-7948','','','copa_robotica2016|R-57','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('31','Colégio Estadual Catuípe ','Rua Arno Sommer, nº 86 ','','Catuípe ','','(55)9119-0453','','','copa_robotica2016|R-58','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('32','Instituto Estadual de Educação João XXIII','rua Artur Ferraz de Almeida Campos, 999','','Giruá','','(55)3361-1066','','','copa_robotica2016|R-52','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('33','Instituto Estadual de Educação Cardeal Pacelli','Rua Ginásio Pio XII, 85','','Três de Maio','','(55)3535-1224','','','copa_robotica2016|R-61','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('34','Colégio Marista Santo Ângelo','Av. Venâncio Aires, 971','','Santo Ângelo','','(55)3931-3000','','','copa_robotica2016|R-44','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('35','Colégio La Salle Medianeira ','Rua Padre Maximiliano von Lassberger, 666','','Cerro Largo - RS ','','(55)8133-7992','','','copa_robotica2016|R-69','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('36','Escola Estadual de Educação Básica Eugênio Frantz ','Rua Monteiro Lobato 514 ','','Cerro Largo ','','(55)3359-2090','','','copa_robotica2016|R-73','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('39','Escola Estadual de Ensino Medio Unirio Carrera Machado','Tiradentes, 1377','','Santo Angelo','','(55)9945-1718','','','copa_robotica2016|R-76','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('40','Colégio Estadual Pedro II ',' Marechal Floriano 3848 ','',' Santo Ângelo ','','(55)9642-3272','','','copa_robotica2016|R-63','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('41','Cooperativa de Trabalho Educacional Dom Hermeto',' Rua Padre Cacique - 455','',' Três de Maio','','(55)9696-0045','','','copa_robotica2016|R-64','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('42','ESCOLA ESTADUAL DE EDUCAÇÃO BÁSICA PADRE ANTÔNIO SEPP ','  AVENIDA ANTUNES RIBAS,2021','','  SÃO MIGUEL DAS MISSÕES','','(55)9651-1205','','','copa_robotica2016|R-70','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('43','Instituto Estadual de Educação Professor Osmar Poppe',' Júlio de Castinhos, 2245 ','',' São Luiz Gonzaga','','(55)8439-5136','','','copa_robotica2016|R-80','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('44','ESCOLA ESTADUAL DE ENSINO MÉDIO DR.AUGUSTO DO NASCIMENTO E SILVA','RUA: DALTRO FILHO 1970 ','',' SANTO ÂNGELO','','(55)9983-3782','','','copa_robotica2016|R-79','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('45','Escola Estadual Onofre Pires',' R. Bento Gonçalves, 841 - Centro, Santo Ângelo - RS','',' Santo Ângelo','','(55)9653-8070','','','copa_robotica2016|R-53','1');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('46','Escola Estadual de Ensino Médio Buriti',' Rua do Comercio, 335 Distrito de Buriti','','Santo Ângelo','','(55)9913-0826','','','copa_robotica2016|R-88','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('47','Instituto Estadual Odão Felippe Pippi / Escola Estadual Augusto Nascimento e Silva',' R. João Henrique Licht, 2502 - Pippi  ','','Santo Ângelo  ','','(55)8113-0656','','','copa_robotica2016|R-56','2');
-- insert into `` (`cod_escola`, `nome_escola`, `end`, `bairro`, `cidade`, `uf`, `fone`, `cep`, `diretor`, `evento`, `qtd_equipes`) values('48','Colégio Estadual Missoes ',' R. Barão do Triunfo, 264 - Centro ','','Santo Ângelo - RS ','','(55)9198-3149','','','copa_robotica2016|R-91','1');
