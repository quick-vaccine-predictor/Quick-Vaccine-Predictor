import
# Creating a Proteosome that takes input from Frond-End (aa/nt), process in k-mers (9/10 aa) and
# compare the result with the data base

# The input can be a sequence of aminoacids or dna:
in_protein = ""
in_dna = True

def get_sequence(inputfile):
    """
    Return the sequence of an input fasta file
    """
    with open(inputfile) as fasta:
        sequence = ""
        id = ""
        for line in fasta:
            line = line.strip()
            if line[0] == ">":
                id = line[1:]
            else:
                sequence += line
        return sequence       

def get_prot():
    """
    The function takes a nucleotide sequence and translates to a protein 
    sequence.
    """
    # Table with all the nucleotides codons and its respective aa.
    table = { 
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
        'TAC':'Y', 'TAT':'Y', 'TAA':'_', 'TAG':'_', 
        'TGC':'C', 'TGT':'C', 'TGA':'_', 'TGG':'W', 
    } 
    sequence = get_sequence(inputfile = "dna_sequence.fasta.txt")
    protein = ""
    if in_dna:
        if len(sequence) %3 == 0: # If the length of the sequence is divisible for 3
            for i in range(0, len(sequence), 3): # While all the length of the sequence, get triplets only
                codon = sequence[i:i + 3] # codon will be every sequence of 3 nucleotides
                protein += table[codon] # add to protein variable the corresponding aa in the table
    else:
        protein = sequence
    return protein

def get_substrings():
    """
    Return lists of substrings of 9 or 10 aa length from the original protein sequence
    """
    protein = get_prot()
    substr_9 = []
    substr_10 = []
    both_9_10 = []
    for aa in range(0, len(protein), 1):
        kmer = protein[aa:aa + 9]
        substr_9.append(kmer)
        kmer = protein[aa:aa + 10]
        substr_10.append(kmer)
    both_9_10 = substr_9 + substr_10
    #substr_9 = [substr for substr in substr_9 if len(substr) == 9]
    #substr_10 = [substr for substr in substr_10 if len(substr) == 10]
    return (substr_9, substr_10)





# Print Input_sequence:
print("\n\nSEQUENCE:\n" + get_sequence(inputfile = "dna_sequence.fasta.txt"))
# Print Protein_sequence:
print("\nPROTEIN:\n" + get_prot())
# Print get_substrings:
print("\nSUBSTRINGS:\n", get_substrings())


    

