<?php

class Kiwee_Chatbot_WebhookController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$inputJson = file_get_contents('php://input');
		$request = Mage::helper('core')->jsonDecode($inputJson);
		$intent = $request['result']['metadata']['intentName'];
		$action = $request['result']['action'];
		error_log(var_export($request, true));
		error_log($intent);

		switch($action) {
			case 'product.list':

				// Select latest inserted Products
				$productCollection = Mage::getModel('catalog/product')->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter('visibility', array(
						'neq' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE))
					->addFinalPrice()
					->addUrlRewrite()
					->addAttributeToSort('created_at', 'desc')
					->setPageSize(5)
					->setCurPage(1);

				$elements = array();
				foreach($productCollection as $product) {
					$productData = array(
						"title" => $product->getName(),
						"image_url" => $product->getImageUrl(),
						"subtitle" => '€ '. number_format($product->getFinalPrice(), 2),
						"buttons"=> array(
							array(
								"type" => "web_url",
								"url" => $product->getProductUrl(),
								"title" => "Go to Website"
							),
							array(
								"type" => "element_share"
							)
						)
					);

					$elements[] = $productData;

				}


				$response = array(
					"speech" => "Here the products you requested:",
					"displayText" => "Here the products you requested:",
					"data" => array(
						"facebook" => array(
							"attachment" => array(
								"type" => "template",
								"payload" => array(
									"template_type" => "generic",
									"elements" => $elements
								)
							)
						)
					)
				);



				break;

			default:

				$response = array(
					"speech" => "I am sorry, I didn't understand. How else can I help you?",
					"displayText" => "I am sorry, I didn't understand. How else can I help you?",
					"data" => array(
						"facebook" => array(
							"text" => "I am sorry, I didn't understand. How else can I help you?",
							"quick_replies" => array(
								array(
									"content_type" => "text",
									"title" => "What's new?",
									"payload" => "product.list"
								),
								array(
									"content_type" => "text",
									"title" => "I need help",
									"payload" => "support"
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