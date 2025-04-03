CREATE TABLE IF NOT EXISTS institutes (
    id SERIAL,
    name VARCHAR(255),
    acronym VARCHAR(8),
    cpf_director VARCHAR(20) DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS students (
    ra SERIAL,
    name VARCHAR(255),
    rg VARCHAR(20),
    cpf VARCHAR(20),
    birthdate DATE,
    institute_id INTEGER NOT NULL,
    PRIMARY KEY (ra)
);

CREATE TABLE IF NOT EXISTS teachers (
    cpf VARCHAR(20),
    name VARCHAR(255),
    classification CHAR(2),
    institute_id INTEGER NOT NULL,
    PRIMARY KEY (cpf)
);

ALTER TABLE students
ADD CONSTRAINT fk_student_institute
FOREIGN KEY (institute_id)
REFERENCES institutes (id);

ALTER TABLE teachers
ADD CONSTRAINT fk_teacher_institute
FOREIGN KEY (institute_id)
REFERENCES institutes (id);

ALTER TABLE institutes
ADD CONSTRAINT fk_institute_director
FOREIGN KEY (cpf_director)
REFERENCES teachers (cpf);

CREATE TABLE IF NOT EXISTS subjects (
    id VARCHAR(5),
    name VARCHAR(255),
    offering_institute INTEGER NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE subjects
ADD CONSTRAINT fk_subject_institute_offering
FOREIGN KEY (offering_institute)
REFERENCES institutes (id);

CREATE TABLE IF NOT EXISTS classes (
    id SERIAL,
    subject_id VARCHAR(5) NOT NULL,
    teacher_cpf VARCHAR(20) NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE classes
    ADD CONSTRAINT fk_class_subject
        FOREIGN KEY (subject_id)
        REFERENCES subjects (id)
        ON DELETE CASCADE,
    ADD CONSTRAINT fk_class_teacher
        FOREIGN KEY (teacher_cpf)
        REFERENCES teachers (cpf)
        ON DELETE CASCADE;

CREATE TYPE GRADE AS ENUM ('A','B','C','D','E');

CREATE TABLE IF NOT EXISTS registration (
    class_id INTEGER NOT NULL,
    student_ra INTEGER NOT NULL,
    grade GRADE,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    PRIMARY KEY (class_id, student_ra)
);

ALTER TABLE registration
    ADD CONSTRAINT fk_class_registration
        FOREIGN KEY (class_id)
        REFERENCES classes (id)
        ON DELETE CASCADE,
    ADD CONSTRAINT fk_class_student
        FOREIGN KEY (student_ra)
        REFERENCES students (ra)
        ON DELETE CASCADE;

INSERT INTO institutes (name, acronym) VALUES
    ('Instituto de Biologia', 'IB'),
    ('Instituto de Artes', 'IA'),
    ('Instituto de Computação', 'IC'),
    ('Faculdade de Engenharia de Alimentos', 'FEA'),
    ('Faculdade de Engenharia Elétrica', 'FEE'),
    ('Faculdade de Filosofia e Ciências Humanas', 'FFCH'),
    ('Faculdade de Medicina', 'FM'),
    ('Faculdade de Enfermagem', 'FE');

INSERT INTO teachers VALUES
	('123.456.789-0', 'Alberto Farias', 'A1', 1),
	('098.765.432-1', 'Beatriz Rodrigues', 'A2', 1),
	('132.465.876-9', 'Cícero Aparecido', 'A1', 2),
	('459.385.098.5', 'Daniel Robson', 'A1', 2),
	('234.534.543-1', 'Eustacio Pessoa', 'B1', 3),
	('111.111.111-1', 'Fernanda Leal', 'A3', 3),
	('222.222.222-2', 'Geovana Lima', 'A1', 6),
	('333.333.333-3', 'Hélio Pedrini', 'B1', 6),
	('444.444.444-4', 'Ivolanda Negrini', 'A1', 8),
	('555.555.555-5', 'João Neto', 'A2', 8),
    ('666.666.666-6', 'Kauane Sanches', 'A1', 4),
    ('777.777.777-7', 'Leonardo Galvão', 'A1', 4),
    ('888.888.888-8', 'Matheus Rodrigues', 'B2', 5),
    ('999.999.999-9', 'Natália Tarcisio', 'A4', 5),
    ('000.000.000-0', 'Otávio Pereira', 'A1', 7),
    ('102.394.587-6', 'Pedro Henrique', 'B2', 7);

INSERT INTO subjects VALUES
    ('BA110', 'Anatomia Humana I', 1),
    ('BB123', 'Bioquímica Básica I', 1),
    ('BC699', 'Introdução à Biologia Sintética', 1),
    ('AC109', 'Música e Ritmo I', 2),
    ('AC110', 'Improvisação Teatral', 2),
    ('AC134', 'Artes da Voz I', 2),
    ('MC102', 'Algoritmos e Programação de Computadores', 3),
    ('MC322', 'Programação Orientada a Objetos', 3),
    ('MC536', 'Bancos de Dados: Teoria e Prática', 3),
    ('FT100', 'Introdução à Engenharia de Alimentos', 4),
    ('FT310', 'Termodinâmica dos Processos', 4),
    ('FT412', 'Bioquímica Básica', 4),
    ('EA513', 'Circuitos Elétricos', 5),
    ('EA614', 'Análise de Sinais', 5),
    ('EA616', 'Análise Linear de Sistemas', 5),
    ('HG107', 'Redação Filosófica I', 6),
    ('HG108', 'Introdução à Filosofia Geral I', 6),
    ('HG303', 'Ética I', 6),
    ('FN704', 'Disfagia I', 7),
    ('FN705', 'Monografia I', 7),
    ('MD126', 'Plantão de Emergência Cirúrgica', 7),
    ('EN112', 'Enfermagem em Saúde Coletiva I', 8),
    ('EN303', 'Diagnóstico de Enfermagem', 8),
    ('EN470', 'Processo de Enfermagem', 8);