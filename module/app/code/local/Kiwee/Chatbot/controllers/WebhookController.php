<?php

class Kiwee_Chatbot_WebhookController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$inputJson = file_get_contents('php://input');
		$request = Mage::helper('core')->jsonDecode($inputJson);
		$intent = $request['result']['metadata']['intentName'];

		error_log(var_export($request, true));
		error_log($intent);

		switch($intent) {
			case 'products-intent':

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
					"speech" => "Here the products you requested:",
					"displayText" => "Here the products you requested:",
					"data" => array(
						"facebook" => array(
							"text" => "Pick a color:",
							"quick_replies" => array(
								array(
									"content_type" => "text",
									"title" => "Red",
									"payload" => "rosso"
								),
								array(
									"content_type" => "text",
									"title" => "Green",
									"payload" => "verde"
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