#!/usr/bin/python
# Creating a Proteosome that takes input from Frond-End (aa/nt), process in k-mers (9/10 aa) and
# compare the result with the data base
import sys
# The input can be a sequence of aminoacids, rna or dna:

#in_dna = bool(int(sys.argv[1]))  # In this case we taste if the script works suposing we have a dna sequence
#in_protein = sys.argv[2] 
#length = int(sys.argv[3])
in_protein=""
in_rna = ""
length = 0

# if length == 0 -> 9
# if length == 1 -> 10
# if length == 2 -> both

def get_sequence(inputfile):
    """
    Return the sequence of an input fasta file
    """
    with open(inputfile) as fasta:
        sequence = ""
        id = ""
        for line in fasta:
            line = line.strip("\n")
            if line != '':
                if line[0] == ">":
                    line = line.split(" ", 1)
                    id = line[0][1:]
                else:
                    sequence += line
            else:
                return sequence       

def get_reverse_complement(sequence):
    """
    Returns the reverse complenent of a DNA or RNA sequence
    """
    # First we set parameters and suppose that we get dna and not rna
    in_dna = True
    in_rna = False
    # Setting dictionaries of complement chain for dna and rna
    dna_complement = {'A': 'T', 'C': 'G', 'G': 'C', 'T': 'A'}
    rna_complement = {'A': 'U', 'C': 'G', 'G': 'C', 'U': 'A'}     
    sequence = get_sequence(inputfile = "sequence_dna_capside.fasta")
    # If we get dna from Front-End:
    if in_dna == True:
        sequence_reverse = sequence[::-1] # Generating reverse sequence
        dna_reverse_complement = ""
        for i in range(0, len(sequence_reverse), 1): #change nt by nt
            nt = sequence_reverse[i:i + 1]
            try:
                dna_reverse_complement += dna_complement[nt]
            except:
                pass
    return dna_reverse_complement

    if in_rna == True:
        sequence_reverse = sequence[::-1]
        rna_reverse_complement = ""
        for i in range(0, len(sequence_reverse), 1):
            nt = sequence_reverse[i:i + 1]
            try:
                rna_reverse_complement += rna_complement[nt]
            except:
                pass
    return rna_reverse_complement            
        

def get_prot():
    """
    The function takes a nucleotide sequence and translates to a protein 
    sequence.
    """
    # Table with all the dna nucleotides codons and its respective aa:
    dna_table = { 
        'ATA':'I', 'ATC':'I', 'ATT':'I', 'ATG':'M', 
        'ACA':'T', 'ACC':'T', 'ACG':'T', 'ACT':'T', 
        'AAC':'N', 'AAT':'N', 'AAA':'K', 'AAG':'K', 
        'AGC':'S', 'AGT':'S', 'AGA':'R', 'AGG':'R',                  
        'CTA':'L', 'CTC':'L', 'CTG':'L', 'CTT':'L', 
        'CCA':'P', 'CCC':'P', 'CCG':'P', 'CCT':'P', 
        'CAC':'H', 'CAT':'H', 'CAA':'Q', 'CAG':'Q', 
        'CGA':'R', 'CGC':'R', 'CGG':'R', 'CGT':'R', 
        'GTA':'V', 'GTC':'V', 'GTG':'V', 'GTT':'V', 
        'GCA':'A', 'GCC':'A', 'GCG':'A', 'GCT':'A', 
        'GAC':'D', 'GAT':'D', 'GAA':'E', 'GAG':'E', 
        'GGA':'G', 'GGC':'G', 'GGG':'G', 'GGT':'G', 
        'TCA':'S', 'TCC':'S', 'TCG':'S', 'TCT':'S', 
        'TTC':'F', 'TTT':'F', 'TTA':'L', 'TTG':'L', 
        'TAC':'Y', 'TAT':'Y',   
        'TGC':'C', 'TGT':'C',  'TGG':'W', 
    } 
    # Table with all the rna nucleotides codons and its respective aa:
    rna_table = {
    'GUC': 'V', 'ACC': 'T', 'ACA': 'T', 'ACG': 'T',
    'GUU': 'V', 'AAC': 'N', 'AGG': 'R', 'UGG': 'W', 
    'AGC': 'S', 'AUC': 'I', 'AGA': 'R', 'AAU': 'N', 
    'ACU': 'T', 'CAC': 'H', 'GUG': 'V', 'CCG': 'P', 
    'CCA': 'P', 'AGU': 'S', 'CCC': 'P', 'GGU': 'G', 
    'UCU': 'S', 'GCG': 'A', 'CGA': 'R', 'CAG': 'Q', 
    'CGC': 'R', 'UAU': 'Y', 'CGG': 'R', 'UCG': 'S', 
    'CCU': 'P', 'GGG': 'G', 'GGA': 'G', 'GGC': 'G', 
    'GAG': 'E', 'UCC': 'S', 'UAC': 'Y', 'CGU': 'R', 
    'GAA': 'E', 'AUA': 'I', 'GCA': 'A', 'CUU': 'L', 
    'UCA': 'S', 'AUG': 'M', 'CUG': 'L', 'AUU': 'I', 
    'CAU': 'H', 'CUA': 'L', 'GCC': 'A', 'AAA': 'K', 
    'AAG': 'K', 'CAA': 'Q', 'UUU': 'F', 'GAC': 'D', 
    'GUA': 'V', 'UGC': 'C', 'GCU': 'A', 'UGU': 'C', 
    'CUC': 'L', 'UUG': 'L', 'UUA': 'L', 'GAU': 'D', 
    'UUC': 'F'}
    # DNA Start and Stop Codons:
    dna_stop_codons = ['TAA', 'TAG', 'TGA']
    dna_start_codons = ['TTG', 'CTG', 'ATG']


    # User can choose which start codon/s want to use (True or False depending if it will be token into account)
    ATG = False
    CTG = False
    TTG = False
    All_start = True
    # The input can be DNA or RNA:
    in_dna = True
    in_rna = False
    # Getting forward and reverse complement sequence:
    sequence_fw = get_sequence(inputfile = "sequence_dna_capside.fasta")
    sequence_rc = get_reverse_complement(sequence = sequence_fw)
    # Setting a condition to False and the dictionarys to Forward and Reverse proteins
    condition = False
    protein_fw = {}
    protein_rc = {}
    # If the input is DNA:
    if in_dna == True:
        c = 0      
        i = 0     
        for i in range(i, len(sequence_fw), 1): #Step must to be one by one and take triplets only
            if c <= 2:
                triplete = sequence_fw[i:i + 3]
                if All_start == True:
                    # When the triplete is a DNA start codon then start to translate to Protein
                    if triplete in dna_start_codons:
                        condition = True
                        protein_fw.setdefault("%s +"%c, "")
                    if condition == True: # It means it has found ATG, and know it translate with a step of 3.
                        protein_fw.setdefault("%s +"%c, "")
                        for i in range(i, len(sequence_fw), 3):
                            codon = sequence_fw[i:i + 3] # codon will be every sequence of 3 nucleotides
                            # Will translate until it found an STOP CODON:
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_fw["%s +"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        #Uploading i and c values to take the other ORFS!! (3 by chain, Fw or RC)
                        i = 0
                        c += 1
                        i += 1
                # If the User choose ATG as one START CODON
                if ATG == True:
                    # When the triplete is ATG then start to translate to Protein
                    if triplete == "ATG":
                        condition = True
                        protein_fw.setdefault("%s ATG +"%c, "")
                    if condition == True: # It means it has found ATG, and know it translate with a step of 3.
                        protein_fw.setdefault("%s ATG +"%c, "")
                        for i in range(i, len(sequence_fw), 3):
                            codon = sequence_fw[i:i + 3] # codon will be every sequence of 3 nucleotides
                            # Will translate until it found an STOP CODON:
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_fw["%s ATG +"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        #Uploading i and c values to take the other ORFS!! (3 by chain, Fw or RC)
                        i = 0
                        c += 1
                        i += 1
            # And do the same to the other START CODONS
                if CTG == True:
                    if triplete == "CTG":
                        condition = True
                        protein_fw.setdefault("%s CTG +"%c, "")
                    if condition == True:
                        protein_fw.setdefault("%s CTG +"%c, "")
                        for i in range(i, len(sequence_fw), 3):
                            codon = sequence_fw[i:i + 3] # codon will be every sequence of 3 nucleotides
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_fw["%s CTG +"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        i = 0
                        c += 1
                        i += 1
                if TTG == True:
                    if triplete == "TTG":
                        condition = True
                        protein_fw.setdefault("%s TTG+"%c, "")
                    if condition == True:
                        protein_fw.setdefault("%s TTG+"%c, "")
                        for i in range(i, len(sequence_fw), 3):
                            codon = sequence_fw[i:i + 3] # codon will be every sequence of 3 nucleotides
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_fw["%s TTG+"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        i = 0
                        c += 1
                        i += 1
            else:
                break
        # We do the same for the Reverse Complement sequence:       
        i = 0 
        c = 0  
        condition = False      
        for i in range(i, len(sequence_rc), 1): # While all the length of the sequence, get triplets only
            if c <= 2:
                triplete = sequence_rc[i:i + 3]
                if All_start == True:
                    # When the triplete is a DNA start codon then start to translate to Protein
                    if triplete in dna_start_codons:
                        condition = True
                        protein_rc.setdefault("%s -"%c, "")
                    if condition == True: # It means it has found ATG, and know it translate with a step of 3.
                        protein_rc.setdefault("%s -"%c, "")
                        for i in range(i, len(sequence_fw), 3):
                            codon = sequence_fw[i:i + 3] # codon will be every sequence of 3 nucleotides
                            # Will translate until it found an STOP CODON:
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_rc["%s -"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        #Uploading i and c values to take the other ORFS!! (3 by chain, Fw or RC)
                        i = 0
                        c += 1
                        i += 1
                if ATG == True:
                    if triplete == "ATG":
                        condition = True
                        protein_rc.setdefault("%s ATG-"%c, "")
                    if condition == True:
                        protein_rc.setdefault("%s ATG-"%c, "")
                        for i in range(i, len(sequence_rc), 3):
                            codon = sequence_rc[i:i + 3] # codon will be every sequence of 3 nucleotides
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_rc["%s ATG-"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        i = 0
                        c += 1
                        i += 1
                if CTG == True:
                    if triplete == "CTG":
                        condition = True
                        protein_rc.setdefault("%s CTG-"%c, "")
                    if condition == True:
                        protein_rc.setdefault("%s CTG-"%c, "")
                        for i in range(i, len(sequence_rc), 3):
                            codon = sequence_rc[i:i + 3] # codon will be every sequence of 3 nucleotides
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_rc["%s CTG-"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        i = 0
                        c += 1
                        i += 1
                if TTG == True:
                    if triplete == "TTG":
                        condition = True
                        protein_rc.setdefault("%s TTG-"%c, "")
                    if condition == True:
                        protein_rc.setdefault("%s TTG-"%c, "")
                        for i in range(i, len(sequence_rc), 3):
                            codon = sequence_rc[i:i + 3] # codon will be every sequence of 3 nucleotides
                            if codon not in dna_stop_codons:                                                    
                                try:
                                    protein_rc["%s TTG-"%c] += (dna_table[codon]) # add to protein variable the corresponding aa in the 
                                except:
                                    pass
                            else:
                                break
                        i = 0
                        c += 1
                        i += 1
            else:
                break
                
    return (protein_fw, protein_rc)         

def get_substrings():
    """
    Return lists of substrings of 9 or 10 aa length from the original protein sequence
    """
    protein = get_prot()
    substr_9 = []
    substr_10 = []
    both_9_10 = []
    for aa in range(0, len(protein), 1):
        if length == 0 or length == 2:
            kmer = protein[aa:aa + 9]
            if len(kmer) == 9:
                substr_9.append(kmer)
        if length == 1 or length == 2: 
            kmer = protein[aa:aa + 10]
            if len(kmer) == 10:
                substr_10.append(kmer)
    both_9_10 = substr_9 + substr_10
    #// In case we want the proteosome only to generate only sequences of length 9 or 10//:

    #substr_9 = [substr for substr in substr_9 if len(substr) == 9] 
    #substr_10 = [substr for substr in substr_10 if len(substr) == 10]
    return both_9_10


if __name__ == "__main__":
    # Print Input_sequence:
    seq1 = get_sequence(inputfile = "sequence_dna_capside.fasta")
    #print("\n\nSEQUENCE:\n" + get_sequence(inputfile = "dna_sequence.fasta.txt"))

    # Print Protein_sequence:
    protein1 = get_prot()
    for tple in protein1:
        for key in tple:
            print("%s\n%s "%(key, tple[key]))
    x=0
    #print("\nPROTEIN:\n" + protein1 +"\n" + str(len(protein1)))
    #rc1 = get_reverse_complement()
    #print(rc1)

    # Print get_substrings:
    output = ""
    lst = get_substrings()
    for i in lst:
        output += "%s " % i
    output = output[:-1]
    #print(output)



    
