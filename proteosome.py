#!/usr/bin/python
# Creating a Proteosome that takes input from Frond-End (aa/nt), process in k-mers (9/10 aa) and
# compare the result with the data base
import sys
# The input can be a sequence of aminoacids or dna:

in_dna = bool(int(sys.argv[1]))  # In this case we taste if the script works suposing we have a dna sequence
in_protein = sys.argv[2] 
length = int(sys.argv[3])

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
    # Table with all the nucleotides codons and its respective aa:
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
        'TAC':'Y', 'TAT':'Y',   
        'TGC':'C', 'TGT':'C',  'TGG':'W', 
    } 
    sequence = in_protein
    protein = ""
    if in_dna:
        for i in range(0, len(sequence), 3): # While all the length of the sequence, get triplets only
            codon = sequence[i:i + 3] # codon will be every sequence of 3 nucleotides
            try:
                protein += table[codon] # add to protein variable the corresponding aa in the table
            except:
                pass
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
    #rint("\n\nSEQUENCE:\n" + get_sequence(inputfile = "dna_sequence.fasta.txt"))
    # Print Protein_sequence:
    # print("\nPROTEIN:\n" + get_prot())
    # Print get_substrings:
    output = ""
    lst = get_substrings()
    for i in lst:
        output += "%s " % i
    output = output[:-1]
    print(output)



    

