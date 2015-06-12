<?php
class XenName_ControllerPublic_Register extends XFCP_XenName_ControllerPublic_Register {

	public function actionRegister() {

		$this->_assertPostOnly();
		$this->_assertRegistrationActive();

		$inputData = $this->_getRegistrationInputDataSafe();
		$data = $inputData['data'];
		$customFields = $inputData['customFields'];
		$errors = $inputData['errors'];
		
		$curl_options = array(
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_SSL_VERIFYPEER  => false,
			CURLOPT_TIMEOUT         => 10,
			CURLOPT_MAXREDIRS       => 5,
			CURLOPT_FOLLOWLOCATION  => true,
			CURLOPT_HEADER          => false
		);

		$ch = curl_init("https://minecraft.net/haspaid.jsp?user="  . $inputData['data']['username']);
		curl_setopt_array($ch, $curl_options);
		$c_res = curl_exec($ch);
		if(curl_error($ch)) {
			$errors[] = new XenForo_Phrase('xenname_curl_error');
		}

		if($c_res == "false") {
			$errors[] = new XenForo_Phrase("xenname_username_invalid");
		}

		if($errors) {
			$fields = $data;
			$fields['tos'] = $this->_input->filterSingle('agree', XenForo_Input::UINT);
			$fields['custom_fields'] = $customFields;
			return $this->_getRegisterFormResponse($fields, $errors);
		}

		return parent::actionRegister();
	}

}