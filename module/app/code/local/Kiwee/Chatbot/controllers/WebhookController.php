<?php

class Kiwee_Chatbot_WebhookController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$inputJson = file_get_contents('php://input');

		$request = Mage::helper('core')->jsonDecode($inputJson);

		error_log(var_export($request, true));

		$intent = $request['result']['metadata']['intentName'];


		error_log($intent);

		/*

{
   "speech":"Here the products you requested:",
   "displayText":"Here the products you requested:",
   "data":{
      "facebook":{
         "attachment":{
            "type":"template",
            "payload":{
               "template_type":"generic",
               "elements":[
                  {
                     "title":"AVIATOR SUNGLASSES",
                     "image_url":"https:\/\/vanilla.dev.kiwee.eu\/media\/catalog\/product\/cache\/2\/image\/9df78eab33525d08d6e5fb8d27136e95\/a\/c\/ace000a_1.jpg",
                     "subtitle":"295.00 € - In stock",
                     "buttons":[
                     	{
                     		"type":"web_url",
                			"url":"https:\/\/vanilla.dev.kiwee.eu\/accessories\/eyewear\/aviator-sunglasses.html",
                			"title":"Go to Website"
                     	},
                     	{
							"type":"element_share"
						}
                     ]
                  },
                  {
                     "title":"JACKIE O ROUND SUNGLASSES",
                     "image_url":"https:\/\/vanilla.dev.kiwee.eu\/media\/catalog\/product\/cache\/1\/image\/9df78eab33525d08d6e5fb8d27136e95\/a\/c\/ace001_1.jpg",
                     "subtitle":"225.00 € - In stock",
                     "buttons":[
                     	{
                     		"type":"web_url",
                			"url":"https:\/\/vanilla.dev.kiwee.eu\/accessories\/eyewear\/jackie-o-round-sunglasses.html",
                			"title":"Go to Website"
                     	},
                     	{
							"type":"element_share"
						}
                     ]
                  }
               ]
            }
         }
      }
   }
}

*/


//		$response = Mage::helper('core')->jsonEncode($response);


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

		$response = Mage::helper('core')->jsonEncode($response);

		$this->getResponse()
			->setBody($response);
	}
}