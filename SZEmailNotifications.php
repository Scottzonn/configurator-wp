<?php 
include( plugin_dir_path( __FILE__ ) . 'SZAdminSettings.php');

class SZEmailNotifications{

	//send email
    //prefix = self/customer/dealer
	public function sz_sendmail(array $buildJson, string $prefix='self'){
		
		$userEmailFields = $this->getSettingsFields($prefix);
		$userEmailFields = $this->parseAllTags($buildJson, $userEmailFields);
		
		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			"From: {$userEmailFields['fromName']} <{$userEmailFields['fromEmail']}>",
			"Reply-To: {$userEmailFields['replyTo']}"
		);

		if(wp_mail($userEmailFields['emailTo'], $userEmailFields['emailSubject'], $userEmailFields['emailTemplate'], $headers)) {
			$response = [
				message => 'this worked',
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
		die();
	}

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

    private function parseAllTags(array $buildJson,string $fieldArray){
		foreach($fieldArray as $field => $fieldSetting){
			$fieldArray[$field] = $this->parseTags($buildJson, $fieldSetting);
		}
		return $fieldArray;
	}

	private function parseTags(array $buildJson, $string){

		$accessories = '';
		foreach($buildJson["accessories"] as $accessory){
			$accessories .= '<li>'. $accessory["name"] . ' - ' . $accessory["rrp"] . '</li>';
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

		return $newStr;

	}
}