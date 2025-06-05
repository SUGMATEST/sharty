import sys
from PIL import Image
import io
import numpy as np
import random
import shutil

def scramble_last_nbits(array, n_bits):
    random.seed(0)
    """
    Scramble the last n bits while maintaining the same number of 1s and 0s
    n_bits: number of least significant bits to process
    """
    # Create mask for the last n bits
    mask_n_bits = (1 << n_bits) - 1  # e.g., for n=3: 0b111
    
    # Get the last n bits
    last_n_bits = array & mask_n_bits
    
    # Create a mapping of original values to scrambled values
    # This ensures consistent scrambling for same input values
    unique_values = np.unique(last_n_bits)
    scrambled_map = {}
    
    for val in unique_values:
        # Count number of 1s in binary representation
        num_ones = bin(val).count('1')
        # Get all possible values with same number of 1s
        possible_values = [i for i in range(mask_n_bits + 1) if bin(i).count('1') == num_ones]
        # Randomly select one (but consistently for the same input value)
        random.seed(val)  # Make it deterministic for same input
        scrambled_map[val] = random.choice(possible_values)
    
    # Apply the scrambling
    result = (array & ~mask_n_bits)  # Clear the last n bits
    for original, scrambled in scrambled_map.items():
        mask = last_n_bits == original
        result[mask] |= scrambled
    
    return result

def process_frame(frame, n_bits=3):
    """Process a single frame of the image"""
    # Store alpha if present
    has_alpha = 'A' in frame.getbands()
    if has_alpha:
        alpha = frame.split()[-1]
        frame = frame.convert('RGB')
    else:
        alpha = None
        frame = frame.convert('RGB')
    
    # Process RGB data
    img_array = np.array(frame)
    # Scramble the last n bits
    img_array = scramble_last_nbits(img_array, n_bits)
    
    # Convert back to image
    frame = Image.fromarray(img_array.astype('uint8'))
    rgb_output = io.BytesIO()
    frame.save(rgb_output, format='PNG', optimize=True)
    frame = Image.open(rgb_output)
    
    if has_alpha:
        frame = frame.convert('RGBA')
        alpha_array = np.array(alpha)
        
        # Only process partial alpha values
        partial_alpha_mask = (alpha_array > 0) & (alpha_array < 255)
        # Scramble the last n bits of partial alpha values
        alpha_array[partial_alpha_mask] = scramble_last_nbits(alpha_array[partial_alpha_mask], n_bits)
        frame.putalpha(Image.fromarray(alpha_array.astype('uint8')))
    
    return frame

def destroy_hidden_data(input_path, output_path, n_bits=3):
    """
    Process image to destroy potential hidden data while preserving transparency.
    For GIFs, just copies the file and returns True.
    
    Parameters:
    - input_path: path to input image
    - output_path: path to save processed image
    - n_bits: number of least significant bits to process (default=3)
    """
    try:
        # Read input file
        with open(input_path, 'rb') as f:
            img = Image.open(f)
            
            # For GIFs, just copy the file and return True
            if img.format == 'GIF':
                shutil.copy2(input_path, output_path)
                return True
                
            # Process static image
            processed_img = process_frame(img, n_bits)
            
            # Save with appropriate format
            if 'A' in processed_img.getbands():
                processed_img.save(output_path, format='PNG', optimize=True)
            else:
                processed_img.save(output_path, format='PNG', optimize=True)
            
            return True
            
    except Exception as e:
        print(f"Error: {str(e)}", file=sys.stderr)
        return False

if __name__ == "__main__":
    if len(sys.argv) < 3 or len(sys.argv) > 4:
        print("Usage: python scramble_stego.py input_path output_path [n_bits]", file=sys.stderr)
        sys.exit(1)
    
    n_bits = int(sys.argv[3]) if len(sys.argv) == 4 else 3
    success = destroy_hidden_data(sys.argv[1], sys.argv[2], n_bits)
    sys.exit(0 if success else 1)
