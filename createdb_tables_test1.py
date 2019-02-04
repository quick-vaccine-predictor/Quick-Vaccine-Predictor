import mysql.connector

mydb = mysql.connector.connect(
    host = "localhost",
    user = "qvp",
    passwd = "Qvp2019.",
    database = "qvp_database"
)

mycursor = mydb.cursor()

# We create the Data Base and check if cretaed:
mycursor.execute("CREATE DATABASE qvp_database")
mycursor.execute("SHOW DATABASES")
for x in mycursor:
    print(x)

# We create the tables Epitope, Antigen, Organism, Protein, HLA, Affinity:
mycursor.execute("CREATE TABLE Epitope (idEpitope INT, seqEpitope VARCHAR(10), startEpitope INT, endEpitope INT, scoreImm FLOAT, idAntigen VARCHAR(20), PRIMARY KEY (idEpitope))")
mycursor.execute("CREATE TABLE Organism (idOrganism INT PRIMARY KEY, nameOrganism VARCHAR(70))")
mycursor.execute("CREATE TABLE Protein (idProtein VARCHAR(20) PRIMARY KEY, nameProtein VARCHAR(70))")
mycursor.execute("CREATE TABLE HLA (idHLA VARCHAR(20) PRIMARY KEY, nameHLA VARCHAR(30))")
mycursor.execute("CREATE TABLE Antigen (idAntigen VARCHAR(20) PRIMARY KEY, nameAntigen VARCHAR(70))")
mycursor.execute("CREATE TABLE Affinity (idEpitope INT, idHLA VARCHAR(20), scoreAff FLOAT, FOREIGN KEY (idEpitope) REFERENCES Epitope(idEpitope), FOREIGN KEY (idHLA) REFERENCES HLA(idHLA))")
# Checking if tables exists:
mycursor.execute("show tables")
for x in mycursor:
    print(x) 

# In case we need to modify a table or delete a table:

#mycursor.execute("alter table KLSE modify <existing_column_name> int auto_increment primary key";)
#mycursor.execute("DROP TABLE IF EXISTS Organism")
#DESCRIBE table_name; --> to see the content of the table in mysql.
