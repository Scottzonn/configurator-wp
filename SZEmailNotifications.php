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
		echo print_r($userEmailFields, true);
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			"From: {$userEmailFields['fromName']} <{$userEmailFields['fromEmail']}>",
			"Reply-To: {$userEmailFields['replyTo']}"
		);

		if(wp_mail($userEmailFields['emailTo'], $userEmailFields['emailSubject'], $userEmailFields['emailTemplate'], $headers)) {
			$response = [
				message => 'Email Sent',
				success => true,
			];
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

		

		$replacements = array(
			'[first name]' 		=>  $buildJson["customer"]["firstName"],
			'[surname]' => 			$buildJson["customer"]["surname"],
			'[full name]' => 		$buildJson["customer"]["firstName"] . ' ' . $buildJson["customer"]["surname"],
			'[email]' => 			$buildJson["customer"]["email"],
			'[postcode]' => 		$buildJson["customer"]["postcode"],
			'[phone]' => 			$buildJson["customer"]["phone"],
			'[address line 1]' => 	$buildJson["customer"]["address"]["address-line-1"],
			'[address line 2]' => 	$buildJson["customer"]["address"]["address-line-2"],
			'[city]' => 			$buildJson["customer"]["address"]["city"],
			'[country]' => 			$buildJson["customer"]["address"]["country"],
			'[state]' => 			$buildJson["customer"]["address"]["state"],
			'[product name]' => 	$buildJson["product"]["name"],
			'[rrp]' => 				$buildJson["model"]["rrp"] . '',
			'[image url]' => 		$buildJson["model"]["featured_image"]["url"],
			'[accessories list]' =>	$accessories
		);
		// echo 'here2 ' . print_r($buildJson, true);

		$newStr = $string;
		foreach($replacements as $placeholder => $literal){
			$newStr = str_replace($placeholder, $literal, $newStr);
		}

		//get contents between loop tags
		$results_num = preg_match_all('/\[acc_loop\](.*?)\[\/acc_loop\]/s', $newStr, $matches);
		if($results_num >= 2) {
			$innerContent = $this->parseLoopContent($buildJson, $newStr);
			preg_replace('/\[acc_loop\](.*?)\[\/acc_loop\]/s', $innerContent, $newStr);
		}


		return $newStr;

	}

	private function parseLoopContent(array $buildJson, $string){

		$res = '';
		foreach($buildJson["accessories"] as $accessory){
			$line = str_replace("[acc_name]", $accessory["accessories"]["name"], $string);
			$line = str_replace("[acc_rrp]", $accessory["accessories"]["rrp"], $line);
			$line = str_replace("[acc_part_number]", $accessory["accessories"]["part_number"], $line);
			$res .= $line;
		}
		return $res;
	}
}