# Egypt National ID Generator

This project generates Egyptian national IDs and stores them in a file named `national_ids.txt`.

## How It Works

1. The script reads the last generated ID from `national_ids.txt` to continue generating IDs sequentially.
2. It initializes starting values based on the last ID.
3. It generates IDs by iterating through possible values for each component of the ID:
   - Decade
   - Year
   - Month
   - Day
   - Country code
   - Birth number
   - Sex
   - Secure number
4. Each generated ID is written to `national_ids.txt`.

## Usage

1. Ensure `national_ids.txt` is in the same directory as the script.
2. Run the script using PHP:
   ```sh
   php egypt_national_id_generator.php
   ```
3. Follow the menu options:
   - Option 1: Generate IDs with default settings.
   - Option 2: Generate IDs with custom settings.
     - You can specify the start year, month, day, country code, birth number, sex, and output file name.
     - You will be asked if you want to start from the last ID in the file.
   - Option 3: Display developer information.
4. The generated IDs will be appended to the specified output file.

## File Structure

- `egypt_national_id_generator.php`: The main script for generating national IDs.
- `national_ids.txt`: The default file where generated IDs are stored.

## Notes

- The script handles leap years and months with different numbers of days.
- The country code ranges from 1 to 27.
- The birth number ranges from 1 to 599.
- The sex digit ranges from 1 to 9.
- The secure number ranges from 0 to 9.
- If the sex digit is odd, the ID is for a male; if even, the ID is for a female.

## Developer

- **Name:** Nabil Fayez
- **GitHub:** [Nabil Fayez](https://github.com/nabil-fayez)
