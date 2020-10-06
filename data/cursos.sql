CREATE TABLE courselist (
  id integer PRIMARY KEY AUTOINCREMENT,
  strCourseDescription varchar(150) NOT NULL,
  curCourseCost double(7,3) NOT NULL,
  intCourseDurationYears int(11) NOT NULL,
  memNotes varchar(150) NOT NULL
); 

CREATE TABLE jposition (
  id integer  PRIMARY KEY AUTOINCREMENT,
  strEmpPosition varchar(100) NOT NULL);
 
CREATE TABLE contact (
  id integer PRIMARY KEY AUTOINCREMENT,
  strContactType varchar(100) NOT NULL
);

INSERT INTO contact (strContactType) VALUES
('Telefono');
INSERT INTO courselist (strCourseDescription, curCourseCost, intCourseDurationYears, memNotes) VALUES
( 'Curso de matematicas', 1500.000, 1, 'no se haran devoluciones');
 INSERT INTO jposition (strEmpPosition) VALUES
( 'Programador');