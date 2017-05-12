<?php

class Kiwee_Chatbot_WebhookController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$inputJson = file_get_contents('php://input');
		$request = Mage::helper('core')->jsonDecode($inputJson);
		$intent = $request['result']['metadata']['intentName'];

		error_log(var_export($request, true));
		error_log($intent);

		$intent = 'products-intent';
		switch($intent) {
			case 'products-intent':

				$response = array(
					"speech" => "Here the products you requested:",
					"displayText" => "Here the products you requested:",
					"data" => array(
						"facebook" => array(
							"attachment" => array(
								"type" => "template",
								"payload" => array(
									"template_type" => "generic",
									"elements" => array(
										array(
											"title" => "AVIATOR SUNGLASSES",
											"image_url" => "https://vanilla.dev.kiwee.eu/media/catalog/product/cache/2/image/9df78eab33525d08d6e5fb8d27136e95/a/c/ace000a_1.jpg",
											"subtitle" => "In stock",
											"buttons"=> array(
												array(
													"type" => "web_url",
													"url" => "https:\/\/vanilla.dev.kiwee.eu\/accessories\/eyewear\/jackie-o-round-sunglasses.html",
													"title" => "Go to Website"
												),
												array(
													"type" => "element_share"
												)
											)
//									"default_action" => array(
//										"type" => "web_url",
//										"url" => "https://vanilla.dev.kiwee.eu/accessories/eyewear/aviator-sunglasses.html",
//										"messenger_extensions" => true,
//										"webview_height_ratio" => "tall",
//										"fallback_url" => "https://vanilla.dev.kiwee.eu/accessories/eyewear/"
//									)
										),
										array(
											"title" => "AVIATOR SUNGLASSES",
											"image_url" => "https://vanilla.dev.kiwee.eu/media/catalog/product/cache/2/image/9df78eab33525d08d6e5fb8d27136e95/a/c/ace000a_1.jpg",
											"subtitle" => "In stock",
//									"default_action" => array(
//										"type" => "web_url",
//										"url" => "https://vanilla.dev.kiwee.eu/accessories/eyewear/aviator-sunglasses.html",
//										"messenger_extensions" => true,
//										"webview_height_ratio" => "tall",
//										"fallback_url" => "https://vanilla.dev.kiwee.eu/accessories/eyewear/"
//									)
										)
									)
								)
							)
						)
					)
				);

				break;
		}

//		$response = Mage::helper('core')->jsonEncode($response);




		$response = Mage::helper('core')->jsonEncode($response);

		$this->getResponse()
			->setBody($response);
	}
}