# Quick Vaccine Predictor
## Description:
QVVP is a public application designed to help speed up the generation of new viral vaccines. It is a student's project from the Mc in Bioinformatics in Health Science from Universitat Pompeu Fabra (UPF). QVP contains a database with information of more than 41.000 viral epitopes from IEDB. Furthermore, it contains already calculated binding simulations for each epitope using netMHCcons, a reliable binding prediction software from DTU Bioinformatics (Denmark). 


## How can we speed up vaccine production?
The problem with vaccine design is that, for each new viral protein there can be L - k + 1 potentialy useful epitopes (where L is the length of the protein and k the length of the epitope). Thus, in a simple protein of 500 aa and with epitopes of 9 aa, 492 epitopes should be tested in assays to determine if they could be used in a vaccine.<br>
To speed this expensive and time consuming process, we selected all viral epitopes of 9 and 10 aa from IEDB which we then performed time-consuming computer simulations of epitope binding and finally stored the results in our database.
With this novel data, researchers can perform several queries to determine which epitopes show more potential to perform in a vaccine.

## Authors:
Altair Chinchilla <br>
Natàlia Segura <br>
Pau Badia i Mompel <br>

QVP, 2019
