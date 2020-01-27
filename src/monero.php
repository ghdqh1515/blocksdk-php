<?php

	namespace BlockSDK;
	
	class Monero extends Base{
		public function getBlockChain(){
			return $this->request("GET","/xmr/block");
		}		
		
		public function getBlock($request){
			$request['offset'] = isset($request['offset'])==false ?0:$request['offset'];
			$request['limit'] = isset($request['limit'])==false ?10:$request['limit'];
			
			return $this->request("GET","/xmr/block/{$request['block']}",[
				"offset" => $request['offset'],
				"limit" => $request['limit']
			]);
		}
		
		public function listAddress($request){
			$request['offset'] = isset($request['offset'])==false ?0:$request['offset'];
			$request['limit'] = isset($request['limit'])==false ?10:$request['limit'];
			
			return $this->request("GET","/xmr/address",[
				"offset" => $request['offset'],
				"limit" => $request['limit']
			]);
		}
		
		public function createAddress($request){
			$request['name'] = empty($request['name'])==false?null:$request['name'];
			
			return $this->request("POST","/xmr/address",[
				"name" => $request['name']
			]);
		}
		
		public function getAddressInfo($request){
			$request['offset'] = isset($request['offset'])==false ?0:$request['offset'];
			$request['limit'] = isset($request['limit'])==false ?10:$request['limit'];
			
			return $this->request("GET","/xmr/address/{$request['address_id']}",[
				"offset" => $request['offset'],
				"limit" => $request['limit'],
				"private_spend_key" => $request['private_spend_key'],
			]);
		}
		
		public function getAddressBalance($request){
			
			return $this->request("GET","/xmr/address/{$request['address_id']}/balance",[
				"private_spend_key" => $request['private_spend_key'],
			]);
		}
		
		public function loadAddress($request){

			return $this->request("POST","/xmr/address/{$request['address_id']}/load",[
				"private_spend_key" => $request['private_spend_key'],
				"password" => $request['password']
			]);
		}
		
		public function unLoadAddress($request){
			
			return $this->request("POST","/xmr/address/{$request['address_id']}/unload");
		}
		
		public function sendToAddress($request){
			if(empty($request['kbfee']) == true){
				$blockChain = $this->getBlockChain();
				$request['kbfee'] = $blockChain['medium_fee_per_kb'];
			}
			
			$request['private_spend_key'] = isset($request['private_spend_key'])==false ?null:$request['private_spend_key'];
			$request['password'] = isset($request['password'])==false ?null:$request['password'];
			
			return $this->request("POST","/xmr/address/{$request['address_id']}/sendtoaddress",[
				"address" => $request['address'],
				"amount" => $request['amount'],
				"private_spend_key" => $request['private_spend_key'],
				"password" => $request['password'],
				"kbfee" => $request['kbfee']
			]);
		}
		
		public function getTransaction($request){
			
			return $this->request("GET","/xmr/transaction/{$request['hash']}");
		}
	}
?>