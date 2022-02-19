<?php 
include_once( plugin_dir_path( __FILE__ ) . 'SZAdminSettings.php');


class SZEmailNotifications{

	//send email
    //prefix = self/customer/dealer
	public function sendMail(array $buildJson, string $prefix='self'){

		$userEmailFields = $this->getEmailFields($prefix);
        if( $prefix==='customer'){
            $userEmailFields["emailTo"] = $buildJson["customer"]["email"];
        }
		$userEmailFields = $this->parseAllTags($buildJson, $userEmailFields);
		// echo print_r($userEmailFields, true);
		$headers = array(
			'Content-type: text/html; charset=UTF-8',
			"From: {$userEmailFields['fromName']} <{$userEmailFields['fromEmail']}>",
			"Reply-To: {$userEmailFields['replyTo']}"
		);


		$HTMLheader = '<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		</head><body>';

		$HTMLfooter = '</body></html>';

		$emailBody = $HTMLheader . $userEmailFields['emailTemplate'] . $HTMLfooter;

		if(wp_mail($userEmailFields['emailTo'], $userEmailFields['emailSubject'], $emailBody, $headers)) {
			$response = [
				message => 'Email Sent',
				success => true,
			];
			echo print_r($emailBody, true);
			echo json_encode($response);

		} else {
			$response = [
				message => 'failed',
				success => false,
			];
			echo json_encode($response);
		}
		
	}

	//move to szadminsettings
    private function getEmailFields(string $prefix){
        $fields = [
			emailTo => 			CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_to", '' ),
			fromName => 		CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_from_name", 'Camper Configurator' ),
			fromEmail => 		CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_from_email", 'Camper Configurator' ),
			emailReplyTo => 	CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_reply_to", 'Camper Configurator' ),
			emailTemplate => 	CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_template", '' ),
			emailSubject => 	CConfiguratorAdminPageFramework::getOption( 'SZAdminSettings', "{$prefix}_email_subject", 'New Camper Submitted' ),
		];
		return $fields;
    }

    private function parseAllTags(array $buildJson, array $fieldArray){
		foreach($fieldArray as $field => $fieldSetting){
			$fieldArray[$field] = $this->parseTags($buildJson, $fieldSetting);
		}
		return $fieldArray;
	}

	private function parseTags(array $buildJson, $string){

		$accessories = '';
		foreach($buildJson["accessories"] as $accessory){
			$accessories .= '<li>'. $accessory["name"] . ' - $' . $accessory["rrp"] . ' - Part No. ' . $accessory["part_number"] .'</li>';
		}
		$accessories = '<ul>' . $accessories . '</ul>';

		
		$customOptionString = '';
		foreach($buildJson["customOptions"] as $option){
			$customOptionString .= '<li>'. 
				$option["screen"]['option_name'] .
				 ': ' . $option["selectedOption"]['option_name'] .
				 '</li>';
		}
		$customOptionString = '<ul>' . $customOptionString . '</ul>';
		

		$replacements = array(
			'[first_name]' 		=>  $buildJson["customer"]["firstName"],
			'[surname]' => 			$buildJson["customer"]["surname"],
			'[full_name]' => 		$buildJson["customer"]["firstName"] . ' ' . $buildJson["customer"]["surname"],
			'[email]' => 			$buildJson["customer"]["email"],
			'[postcode]' => 		$buildJson["customer"]["postcode"],
			'[phone]' => 			$buildJson["customer"]["phone"],
			'[address_line_1]' => 	$buildJson["customer"]["address"]["address-line-1"],
			'[address_line_2]' => 	$buildJson["customer"]["address"]["address-line-2"],
			'[city]' => 			$buildJson["customer"]["address"]["city"],
			'[country]' => 			$buildJson["customer"]["address"]["country"],
			'[state]' => 			$buildJson["customer"]["address"]["state"],
			'[product_name]' => 	$buildJson["product"]["name"],
			'[rrp]' => 				$buildJson["rrp"] . '',
			'[totalPrice]' => 		$buildJson["totalPrice"] . '',
			'[image_url]' => 		$buildJson["model"]["featured_image"]["url"],
			'[salesperson]' => 		$buildJson["dealerAdmin"]["salesperson"],
			'[location]' => 		$buildJson["dealerAdmin"]["location"],
			'[match_wheels]' => 		$buildJson["dealerAdmin"]["matchWheels"],
			'[towVehicleMake]' => 		$buildJson["dealerAdmin"]["towVehicleMake"],
			'[towVehicleModel]' => 		$buildJson["dealerAdmin"]["towVehicleModel"],
			'[towVehicleYear]' => 		$buildJson["dealerAdmin"]["towVehicleYear"],
			'[towVehicleWheelSize]' => 	$buildJson["dealerAdmin"]["towVehicleWheelSize"],
			'[towVehicleTyreSize]' 	=> 	$buildJson["dealerAdmin"]["towVehicleTyreSize"],
			'[specialRequests]' 	=> 	$buildJson["dealerAdmin"]["specialRequests"],
			'[comments]' 			=> 	$buildJson["dealerAdmin"]["comments"],
			'[buildDateRequested]' 	=>	$buildJson["dealerAdmin"]["buildDateRequested"],
			'[discount]' 			=> 	$buildJson["dealerAdmin"]["discount"],
			'[discountType]' 		=>	$buildJson["dealerAdmin"]["discountType"],
			'[accessories_list]'	=>	$accessories,
			'[custom_options_list]' 		=>	$customOptionString
		);
		// echo 'here2 ' . print_r($buildJson, true);

		$newStr = $string;
		foreach($replacements as $placeholder => $literal){
			$newStr = str_replace($placeholder, $literal, $newStr);
		}

		//get contents between loop tags
		$matches_num = preg_match_all('/\[acc_loop\](.*?)\[\/acc_loop\]/s', $newStr, $matches);
		if($matches_num >= 1) {
			$innerContent = $this->parseLoopContent($buildJson, $matches[1][0]);
			$newStr = preg_replace('/\[acc_loop\](.*?)\[\/acc_loop\]/s', $innerContent, $newStr);
			$newStr .= "here is the match";
			$newStr .= print_r($matches, true);
			$newStr .= "here is the content" . $innerContent;
		} 


		return $newStr;

	}

	private function parseLoopContent(array $buildJson, $string){

		$res = '';
		foreach($buildJson["accessories"] as $accessory){
			$line = str_replace("[acc_name]", $accessory["name"], $string);
			$line = str_replace("[acc_rrp]", $accessory["rrp"], $line);
			$line = str_replace("[acc_part_number]", $accessory["part_number"], $line);
			$res .= $line;
		}
		return $res;
	}
}