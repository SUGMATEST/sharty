import os
import cv2
import pdqhash
import sys
import numpy as np

def compute_hash(image_path):
    image = cv2.imread(image_path)
    image = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
    hash_vector, _ = pdqhash.compute(image)
    hash_bytes = bytes(hash_vector)
    hash_bytes = np.packbits(hash_vector)
    hash_hex = ''.join(format(byte, '02x') for byte in hash_bytes)
    return hash_hex
    #return ""
if __name__ == "__main__":
    image_path = sys.argv[1]
    print(compute_hash(image_path))
