import sys
from Bio import SeqIO
infile = sys.argv[1]
record = SeqIO.read(infile, "fasta")
table = int(sys.argv[2])
min_pro_len = int(sys.argv[3])

def find_orfs_with_trans(seq, trans_table, min_protein_length):
    answer = []
    seq_len = len(seq)
    for strand, nuc in [(+1, seq), (-1, seq.reverse_complement())]:
        for frame in range(3):
            trans = str(nuc[frame:].translate(trans_table))
            trans_len = len(trans)
            aa_start = 0
            aa_end = 0
            while aa_start < trans_len:
                aa_end = trans.find("*", aa_start)
                if aa_end == -1:
                    aa_end = trans_len
                if aa_end-aa_start >= min_protein_length:
                    if strand == 1:
                        start = frame+aa_start*3
                        end = min(seq_len,frame+aa_end*3+3)
                    else:
                        start = seq_len-frame-aa_end*3-3
                        end = seq_len-frame-aa_start*3
                    answer.append((start, end, strand, frame, trans[aa_start:aa_end]))
                aa_start = aa_end+1
    return answer

orf_list = find_orfs_with_trans(record.seq, table, min_pro_len)
for start, end, strand, frame, pro in orf_list:
    print("%s,%s,%s,%s:%s,%s" % (strand, frame, len(pro), start, end, pro))
