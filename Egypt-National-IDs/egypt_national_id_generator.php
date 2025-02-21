<?php
// Function to display the menu and get user input
function display_menu()
{
    echo "==============================\n";
    echo "Egypt National ID Generator\n";
    echo "1. Generate IDs with default settings (its Hard option)\n";
    echo "2. Generate IDs with custom settings\n";
    echo "3. Developer Info\n";
    echo "==============================\n";
    echo "Select an option: ";
    $option = trim(fgets(STDIN));
    return $option;
}

// Function to get custom settings from the user
function get_custom_settings()
{
    $settings = [];
    echo "Enter start year (1900-2099) or press Enter to use all years: ";
    $input = trim(fgets(STDIN));
    $settings['year'] = $input === '' ? null : (int)$input;
    echo "Enter start month (1-12) or press Enter to use all months: ";
    $input = trim(fgets(STDIN));
    $settings['month'] = $input === '' ? null : (int)$input;
    echo "Enter start day (1-31) or press Enter to use all days: ";
    $input = trim(fgets(STDIN));
    $settings['day'] = $input === '' ? null : (int)$input;
    echo "Enter country code (1-27) or press Enter to use all country codes: ";
    $input = trim(fgets(STDIN));
    $settings['country_code'] = $input === '' ? null : (int)$input;
    echo "Enter count of birth numbers (1-599) or press Enter to use all birth numbers: ";
    $input = trim(fgets(STDIN));
    $settings['birth_number'] = $input === '' ? null : (int)$input;
    echo "Enter sex (male/female) or press Enter to use both: ";
    $input = trim(fgets(STDIN));
    $settings['sex'] = $input === '' ? null : strtolower($input);
    echo "Enter output file name (default: national_ids.txt): ";
    $input = trim(fgets(STDIN));
    $settings['file_name'] = $input === '' ? 'national_ids.txt' : $input;
    return $settings;
}

// Function to display developer information
function display_developer_info()
{
    echo "Developer Info\n";
    echo "Name: Nabil Fayez\n";
    echo "GitHub: https://github.com/nabil-fayez\n";
}

// Function to ask if the user wants to display the IDs
function ask_display_ids()
{
    echo "Do you want to display the generated IDs? (yes/no): ";
    $input = trim(fgets(STDIN));
    return strtolower($input) === 'yes';
}

// Function to ask if the user wants to start from the last ID in the file
function ask_start_from_last_id()
{
    echo "Do you want to start from the last ID in the file? (yes/no): ";
    $input = trim(fgets(STDIN));
    return strtolower($input) === 'yes';
}

// Read the last line from the file to get the last ID
function get_last_id($file_name)
{
    $last_id = '';
    if (file_exists($file_name)) {
        $file = fopen($file_name, "r");
        if ($file) {
            while (($line = fgets($file)) !== false) {
                $last_id = trim($line);
            }
            fclose($file);
        }
    }
    return $last_id;
}

// Initialize starting values based on the last ID
$start_decate = 2;
$start_year = 1;
$start_month = 1;
$start_day = 1;
$start_country_code = 1;
$start_birth_number = 1;
$start_sex = 1;
$start_secure_number = 0;

function format_year($year)
{
    return $year % 100; // Convert to two-digit year
}

function format_decate($year)
{
    // Calculate decade
    if ($year >= 2000) {
        return 3;
    } elseif ($year >= 1900 && $year < 2000) {
        return 2;
    }
}

function format_sex_start($sex)
{
    if ($sex === 'male') {
        return [
            'sex_start' => 1,
            'sex_end' => 10,
            'sex_step' => 2,
        ];
    } elseif ($sex === 'female') {
        return [
            'sex_start' => 2,
            'sex_end' => 10,
            'sex_step' => 2,
        ];
    } else {
        return [
            'sex_start' => 1,
            'sex_end' => 10,
            'sex_step' => 1,
        ];
    }
}

// Main program
while (true) {
    // Display menu and get user option
    $option = display_menu();
    if ($option == 1 || $option == 2) {
        $file_name = 'national_ids.txt';
        if ($option == 2) {
            $custom_settings = get_custom_settings();
            if ($custom_settings['year'] !== null) {
                $start_year = format_year($custom_settings['year']);
                $start_decate = format_decate($custom_settings['year']);
            }
            $start_month = $custom_settings['month'] ?? 1;
            $start_day = $custom_settings['day'] ?? 1;
            $start_country_code = $custom_settings['country_code'] ?? 1;
            $start_birth_number = $custom_settings['birth_number'] ?? 1;
            $start_sex = $custom_settings['sex'];
            $file_name = $custom_settings['file_name'];
        }

        // Get the last ID from the specified file
        $last_id = get_last_id($file_name);

        if ($last_id && ask_start_from_last_id()) {
            $start_decate = (int)substr($last_id, 0, 1);
            $start_year = (int)substr($last_id, 1, 2);
            $start_month = (int)substr($last_id, 3, 2);
            $start_day = (int)substr($last_id, 5, 2);
            $start_country_code = (int)substr($last_id, 7, 2);
            $start_birth_number = (int)substr($last_id, 9, 3);
            $start_sex = (int)substr($last_id, 12, 1);
            $start_secure_number = (int)substr($last_id, 13, 1) + 1;
        }

        // Override with custom settings if provided
        if ($option == 2) {
            if ($custom_settings['year'] !== null) {
                $start_year = format_year($custom_settings['year']);
                $start_decate = format_decate($custom_settings['year']);
            }
            $start_month = $custom_settings['month'] ?? $start_month;
            $start_day = $custom_settings['day'] ?? $start_day;
            $start_country_code = $custom_settings['country_code'] ?? $start_country_code;
            $start_birth_number = $custom_settings['birth_number'] ?? $start_birth_number;
            $start_sex = $custom_settings['sex'] ?? $start_sex;
        }

        // Ask if the user wants to display the IDs
        $display_ids = ask_display_ids();

        for ($decate = $start_decate; $decate < 4; $decate++) {
            for ($year = $start_year; $year < 100; $year++) {
                for ($month = $start_month; $month < 13; $month++) {
                    for ($day = $start_day; $day < 32; $day++) {
                        if ($day == 31 && ($month == 2 || $month == 4 || $month == 6 || $month == 9 || $month == 11)) {
                            continue;
                        } else if ($day == 30 && $month == 2) {
                            continue;
                        } else if ($day == 29 && $month == 2 && $year % 4 != 0) {
                            continue;
                        } else {
                            for ($country_code = $start_country_code; $country_code < 28; $country_code++) {
                                for ($birth_number = $start_birth_number; $birth_number < 600; $birth_number++) {
                                    $sex_settings = format_sex_start($start_sex);
                                    for ($sex = $sex_settings['sex_start']; $sex < $sex_settings['sex_end']; $sex += $sex_settings['sex_step']) {
                                        for ($secure_number = $start_secure_number; $secure_number < 10; $secure_number++) {
                                            // format the decate to 1 digit
                                            $decate = str_pad($decate, 1, "0", STR_PAD_LEFT);
                                            // format the year to 2 digits
                                            $year = str_pad($year, 2, "0", STR_PAD_LEFT);
                                            // format the month to 2 digits
                                            $month = str_pad($month, 2, "0", STR_PAD_LEFT);
                                            // format the day to 2 digits
                                            $day = str_pad($day, 2, "0", STR_PAD_LEFT);
                                            //  format the country code to 2 digits
                                            $country_code = str_pad($country_code, 2, "0", STR_PAD_LEFT);
                                            // format the birth number to 3 digits
                                            $birth_number = str_pad($birth_number, 3, "0", STR_PAD_LEFT);
                                            // format sex to 1 digit
                                            $sex = str_pad($sex, 1, "0", STR_PAD_LEFT);
                                            // format secure number to 1 digit
                                            $secure_number = str_pad($secure_number, 1, "0", STR_PAD_LEFT);
                                            // write the national id to the file
                                            $national_id = $decate . $year . $month . $day . $country_code . $birth_number . $sex . $secure_number;
                                            // display the national id if the user chose to
                                            if ($display_ids) {
                                                echo ($national_id) . PHP_EOL;
                                            }
                                            // write the national id to the file
                                            file_put_contents($file_name, $national_id . PHP_EOL, FILE_APPEND);
                                        }
                                        $start_secure_number = 0;
                                    }
                                    $sex_settings = format_sex_start($start_sex); // Reset sex settings for the next loop
                                }
                                $start_birth_number = 1;
                            }
                            $start_country_code = 1;
                        }
                    }
                    $start_day = 1;
                }
                $start_month = 1;
            }
            $start_year = 1;
        }
    } elseif ($option == 3) {
        display_developer_info();
    } else {
        echo "Invalid option. Please try again.\n";
    }
}