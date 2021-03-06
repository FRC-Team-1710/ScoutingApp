<?php

    /*
     * This script is more of a fun one that doesn't really server a proper purpose.
     * It will look at all the events provided and then determine how the distribution
     * of countries throughout the teams. It will then determine how many of those teams
     * finished in the top X. X being an arbitrary number that you can set. Right now the
     * script will look at robots in the top 25. You can update the $range_for_top_teams
     * variable to change the weight
     */
    require_once __DIR__ . '/../../vendor/autoload.php';
    use TheBlueAlliance_PHPWrapper\TBARequest;

    // This chunk of the code is what handles the evnet that we want to read out of
    // An alternative would be commenting this section out and then hardcoding the
    // target_event and the target_team
    $target_divisions = null;
    if (isset($argv[1])) {
        $target_divisions = $argv[1];
    } else {
        print_r(
            "Please provide an event as an argument. The proper execution for this script is \n\n" .
            "php top-team-country-distribution.php {target_divisions} \n\n" .
            "An example of an acceptable paramset would be '2017arc, 2017cars, 2017cur, 2017dal, 2017dar, 2017tes'"
        );
        die();
    }

    // Initialize the Library with the required information
    $tbaRequest = new TBARequest();

    $divisions = explode(', ', $target_divisions);

    // Containers that we are going to store data in once it has been parsed
    $top_team_country_mapping_per_division_array = [];
    $all_team_mapping_per_division_array = [];
    $range_for_top_teams = 25;

    foreach ($divisions as $division) {

        // Fetch the the teams in order of rank from TBA
        $ranking_set = $tbaRequest->getEventRankings(['event_key' => $division]);

        // Containers we fill each iteration. Once we are finished iterating through
        // all the teams we set this array to the global container
        $top_teams_count_per_country = [];
        $total_teams_per_country = [];

        // Used to determine how many teams we are showing
        $iteration_count = 1;

        foreach ($ranking_set->rankings as $ranking_position) {

            // Fetch the teams information. This will allow us to determine
            // Country name
            $team_info = $tbaRequest->getTeam(['team_key' => $ranking_position->team_key]);

            // Lowercase the country name so it's easier to work with. This ensures
            // that all data will be consistent
            $lower_case_country_name = strtolower($team_info->country);

            // If we are still within our top X then we can add this team to the
            // top teams array
            if ($iteration_count <= $range_for_top_teams) {

                // If this is the first time we have found  a team from this country
                // then we wont have any information in the array. We can create
                // a new index and set it's value to 1 since this team is the first.
                // If it is not our first time finding a team from this country
                // then we will already have data set. We can just increment the
                // existing value by 1
                if (!array_key_exists($lower_case_country_name, $top_teams_count_per_country)) {
                    $top_teams_count_per_country[$lower_case_country_name] = 1;
                } else {
                    $top_teams_count_per_country[$lower_case_country_name] += 1;
                }
            }

            // Essentially the same thing that we did above. The difference here is
            // that we are adding every single team. Not just those in the top X
            if (!array_key_exists($lower_case_country_name, $total_teams_per_country)) {
                $total_teams_per_country[$lower_case_country_name] = 1;
            } else {
                $total_teams_per_country[$lower_case_country_name] += 1;
            }

            // At the end of each team iteration we can increment the count to
            // ensure that we aren't going over our top X
            $iteration_count++;
        }

        // After finishing the team - country mapping we can add a new index
        // for the division to the global array. This will be used below
        // for output
        $top_team_country_mapping_per_division_array[$division] = $top_teams_count_per_country;
        $all_team_mapping_per_division_array[$division] = $total_teams_per_country;
    }

    // This variable array is going to be used to store all the calculated information.
    // This is generated by combining all of the output for the multiple divisions that
    // we searched for
    $calculated_totals_for_output = [];

    // Now it's time for output. We can iterate over all of the division values
    // that we have already found to generated our data
    foreach ($top_team_country_mapping_per_division_array as $division_key => $division_values) {
        print_r($division_key . "\n");

        // Each inner country that we have stored needs it's information
        // to be output. We do that in this iteration
        foreach ($division_values as $country_name => $country_value) {

            // This check is the same as the one that we did above when generating
            // the array that we are currently iterating. It will populate the new
            // array containing the total values for each country
            if (array_key_exists($country_name, $calculated_totals_for_output)) {
                $calculated_totals_for_output[$country_name]['total'] += $all_team_mapping_per_division_array[$division_key][$country_name];
                $calculated_totals_for_output[$country_name]['top_teams'] += $country_value;
            } else {
                $calculated_totals_for_output[$country_name]['total'] = $all_team_mapping_per_division_array[$division_key][$country_name];
                $calculated_totals_for_output[$country_name]['top_teams'] = $country_value;
            }

            // Now that we have allocated the data above, we can actually output
            // the values for this country
            print_r(
                $country_name .
                "; " .
                round($country_value / $all_team_mapping_per_division_array[$division_key][$country_name] * 100)  .
                "% (" .
                $country_value .
                "/" .
                $all_team_mapping_per_division_array[$division_key][$country_name] .
                ")\n"
            );
        }

        print_r("\n\n");
    }

    // The final step of this process is to output the Totals for each of the countries
    // This can be done by iterating over the totals array that we just built
    print_r("Totals\n---------------------------------\n");
    foreach ($calculated_totals_for_output as $country_name => $country_data) {
        print_r("Total Robots from " . $country_name . ": " . $country_data['total'] . "\n");
        print_r("Total Robots in top {$range_for_top_teams} from " . $country_name . ": " . $country_data['top_teams'] . "\n");
        print_r("Percent in top {$range_for_top_teams}: " . round($country_data['top_teams'] / $country_data['total'] * 100) . "%\n\n");
    }
