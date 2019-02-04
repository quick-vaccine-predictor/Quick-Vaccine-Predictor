# Link from file "alele_dict.py" the id for each HLA in the file "affinity_table"
from alele_dict import alele_dict


def HLA_id_modified(input_filename, output_filename):
    """
    This function relates the HLA of the affiniy_table.txt file 
    to the HLA ID in the allel_dictionary, and generates an output
    file with the HLA_id, logScore(for each epitope) and Affinity
    (strongness of the binding)
    """
    out_file = open(output_filename, "w")
    with open(input_filename) as f:
        inverse_dict = {value:key for key, value in alele_dict.items()} # Reversing key value for value key in alele_dict 
        for line in f:
            info = line.strip().split("\t")
            id = info[0]
            HLA = info[1]
            logScore = info[2]
            affinityScore = info[3]
            if HLA in inverse_dict:
                id = inverse_dict[HLA]
            out_file.write("%s\t%s\t%s\n"%(id, logScore, affinityScore)) # The out_put file is the data to be uploaded in the HLA table for Database.
        out_file.close()              

if __name__ == "__main__":
    print(HLA_id_modified(input_filename = "affinity_table.txt", output_filename = "HLA_SQL_table.txt"))


