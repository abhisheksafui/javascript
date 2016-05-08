<!DOCTYPE html>
<html lang ="en">
<head>
	<title>MQTT Test client</title>
	<script src="includes/mqttws31.js"></script>
	

	<script>  //-----------MQTT global objects---------- 	
			// Create a client instance: Broker, Port, Websocket Path, Client ID
			client = new Paho.MQTT.Client("m10.cloudmqtt.com" , 32291 , "myclientid_1234");
			 
			// set callback handlers
			client.onConnectionLost = function (responseObject) {
				console.log("Connection Lost: "+responseObject.errorMessage);
			}
			 
			client.onMessageArrived = function (message) {
			  console.log("Message Arrived: "+message.payloadString);
			}
			 
			// Called when the connection is made
			function onConnect(){
				console.log("Connected!......");
				subscribe_bcast();
			}
			 
			// Connect the client, providing an onConnect callback
			/*
			client.connect({
				onSuccess: onConnect,
				mqttVersion: 3,
				userName : "abhi",
				password : "abhi123",
				useSSL: true
			});
			*/
	</script>
	
	<script>  //-----------functions---------- 	
		function connect(){			
			console.log("connect click....");
			client.connect({
				onSuccess: onConnect,
				mqttVersion: 3,
				userName : "abhi",
				password : "abhi123",
				useSSL: true
			});
		}
		function pump_on(){
			// Publish a Message
			var msg = '{"msgtype"  : 1,'+
						'"senderid" : "APP1",'+ 
						'"nodename" : "Abhic2",'+
						'"items"    : [{ "id" : "SW1" }]'+
						'}';
			console.log(msg);
			
			var message = new Paho.MQTT.Message(msg);
			message.destinationName = "/FARM1/GW1";
			message.qos = 0;
			client.send(message);
		}
		function pump_off(){
			// Publish a Message
			var msg = '{"msgtype"  : 3,'+
						'"senderid" : "APP1",'+ 
						'"nodename" : "SW1",'+
						'"nodeid"   : 5,'+
						'"items"    : [ { "id" : "PUMP1" , "value" : "OFF" }  ]'+
						'}';
			console.log(msg);
			
			var message = new Paho.MQTT.Message(msg);
			message.destinationName = "/farmer1/field1/pump1";
			message.qos = 0;
			client.send(message);
		}
		function subscribe_bcast(){
			client.subscribe("/APP1");
			client.onMessageArrived = function (message) {
				  console.log("Message Arrived: " + message.payloadString);
				  console.log("Topic:     " + message.destinationName);
				  console.log("QoS:       " + message.qos);
				  console.log("Retained:  " + message.retained);
				  // Read Only, set if message might be a duplicate sent from broker
				  console.log("Duplicate: " + message.duplicate);
			}
			
		}
	</script>
</head>
<body>
				
	<button type="button" onclick="connect()">Connect</button>
	<button type="button" onclick="pump_on()">GET</button>			
	<button type="button" onclick="pump_off()">pump off</button>			
</body>
</html>
