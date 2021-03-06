<?php

namespace TheBlueAlliance_PHPWrapper\Utils;

/**
 * The cURLCallable class is what allows us to make all of our cURL requests
 * to the API. This gives us a centralized point that we can do all of the
 * tedious work such as setting the app header that The Blue Alliance requests
 * as well as actually make our cURL request
 */
class cURLCallable {

	// Base information about the request we are going to make
	private $api_key;

	// Base URL that we are going to call
	private $base_url = "https://thebluealliance.com/api/v3/";

    // Any additional options that were passed through the request
    private $return_json = false;

	/**
	 * The Constructor allows us to actually create our cURLCallable object
	 * that we will use to make our cURL request the The Blue Alliance.
	 * This Constructor takes in the information that we need for the unique
	 * header that we have to send as well as build that header for us
	 * @param String | String $__api_key              - API Key for your app generated on The Blue Alliance
     *                                                @param Boolean return_json - Whether you want to be returned
     *                                                                             a JSON array straight from the API,
     *                                                                             or an object that can easily be manipulated
     *                                                                             by PHP
	 */
	public function  __construct($__api_key, $__options) {

        // Ensure that all of the data provided is valid and can be properly
        // utilised
        if (!is_string($__api_key)) {
            throw new \Exception("You must provide a String version of your API Key");
        }

        if (!is_array($__options)) {
            throw new \Exception("The options provided must be in the form of a Key => Value array.");
        }

		$this->api_key = $__api_key;

        // Iterate over each of the options that were provided in the Array.
        // We will set the private variable to be the value of the option
        // that was passed. If an option was passed that doesn't exist then
        // we will silently fail as nothing terrible is actually happening
        foreach ($__options as $option_name => $option_value) {
            $this->$option_name = $option_value;
        }
	}

	/**
	 * Our actual cURL request to the Blue Alliance Server. This is where we
	 * compile all of our headers as well as any other information thar we need
	 * to actually make the request. This is where the bulk of the work is done
	 * @param  string  $url                    - The URL that you want to retrieve data from
	 * @param  array   $request_parameters     - Key/Value pair array of headers / values that you wish to set
	 * @param  boolean $return_response_status - Determines whether or not you want the response status in the return array
	 * @return Array
	 */
	public function call($url, $request_parameters = [], $return_response_status = false) {

        /*----------------------------------------------------------------------
        --------------------------------cURL Execution--------------------------
        ----------------------------------------------------------------------*/
		$curl = curl_init();

		// Set our default headers that we know will be set everytime
		$request_headers = [
			"X-TBA-Auth-Key: {$this->api_key}"
		];

		// Set our conditional headers that might of been passed throught the function
		foreach ($request_parameters as $request_parameter_key => $request_parameter_value) {
			$request_headers[$request_parameter_key] = $request_parameter_value;
		}

		// Build our cURL request
		curl_setopt_array(
			$curl,
			[
				CURLOPT_URL 			=> $this->base_url . $url,
				CURLOPT_RETURNTRANSFER 	=> true,
				CURLOPT_VERBOSE			=> false,
				CURLOPT_SSL_VERIFYPEER 	=> false,
				CURLOPT_FOLLOWLOCATION 	=> true,
				CURLOPT_HTTPHEADER		=> $request_headers
			]
		);

		// Execute the cURL request
	    $result 		= curl_exec($curl);

		// check our cURL request for the status. This will give us more information
		// about the response
		$result_status 	= curl_getinfo($curl);

		// End the cURL request to free up data
	    curl_close($curl);

        /*----------------------------------------------------------------------
        --------------------------------Data Return-----------------------------
        ----------------------------------------------------------------------*/

        // If the user specified that they wanted an object returned rather than
        // the API's JSON, we can decode it here before we do any further
        // interaction
        if (!$this->return_json) {
            $result = json_decode($result);
        }

		// Return our response to the user
		if ($result_status['http_code'] == 200) {
			if ($return_response_status) {
                $result_status['data'] = $result;
				return $result_status;
			}

			return $result;
		} elseif ($result_status['http_code'] == 404) {
			throw new \Exception("The requested URL was not found.");
		} elseif ($result_status['http_code'] == 301) {
			throw new \Exception("The requested URL has moved.");
		} else {
			throw new \Exception("An error has occured with code {$result_status['http_code']}");
		}
	}
}
