<!DOCTYPE html>
<html lang ="en">
<head>
	<title>MQTT Test client</title>
	<script src="includes/mqttws31.js"></script>
	

	<script>  //-----------MQTT global objects---------- 	
			// Create a client instance: Broker, Port, Websocket Path, Client ID
			client = new Paho.MQTT.Client("localhost" , 8883 , "myclientid_123213123123");
			 
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
			}
			 
			// Connect the client, providing an onConnect callback
			/*
			client.connect({
				onSuccess: onConnect,
				mqttVersion: 3,				
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
			var message = new Paho.MQTT.Message("pump_on");
			message.destinationName = "/farmer1/field1/pump1";
			message.qos = 0;
			client.send(message);
		}
		function pump_off(){
			// Publish a Message
			var message = new Paho.MQTT.Message("pump_off");
			message.destinationName = "/farmer1/field1/pump1";
			message.qos = 0;
			client.send(message);
		}
	</script>
</head>
<body>
				
	<button type="button" onclick="connect()">Connect</button>
	<button type="button" onclick="pump_on()">pump on</button>			
	<button type="button" onclick="pump_off()">pump off</button>
</body>
</html>