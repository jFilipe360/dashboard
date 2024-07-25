<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class SensorController extends Controller
{
    // Show the interval update form
    public function showForm()
    {
        return view('update-interval');
    }

    // Show the interval update form
    public function showFlowForm()
    {
        return view('update-flow');
    }

    // Handle the interval update form submission
    public function updateInterval(Request $request)
    {
        $request->validate([
            'interval' => 'required|integer|min:1000',
        ]);

        $interval = $request->input('interval');

        try {
            // Load configurations from .env
            $host = env('MQTT_HOST');
            $port = env('MQTT_PORT');
            $topic = env('MQTT_INTERVAL_TOPIC');
            $username = env('MQTT_USERNAME');
            $password = env('MQTT_PASSWORD');
            $clientId = env('MQTT_CLIENT_ID');

            // Instantiate MQTT client
            $mqtt = new MqttClient($host, $port, $clientId);
            $connectionSettings = (new ConnectionSettings)
                ->setUsername($username)
                ->setPassword($password)
                ->setKeepAliveInterval(60);

            Log::info('Attempting to connect to MQTT broker', ['host' => $host, 'port' => $port]);
            $mqtt->connect($connectionSettings, true);

            Log::info('Publishing message to MQTT topic', ['topic' => $topic, 'message' => $interval]);
            $mqtt->publish($topic, strval($interval), 0);
            $mqtt->disconnect();

        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to update interval: ' . $e->getMessage());

            // Handle connection or publishing errors
            return redirect()->route('show-interval-form')->with('error', 'Failed to update interval: ' . $e->getMessage());
        }
    }

    // Handle the flow update form submission
    public function updateFlow(Request $request)
    {
        // Log the request
        Log::info('Received flow update request', $request->all());

        $request->validate([
            'flow' => 'required|integer|min:0|max:100',
        ]);

        $interval = $request->input('flow');

        try {
            // Load configurations from .env
            $host = env('MQTT_HOST');
            $port = env('MQTT_PORT', 1883);
            $topic = env('MQTT_CAUDAL_TOPIC', 'flowtopic');
            $username = env('MQTT_USERNAME');
            $password = env('MQTT_PASSWORD');
            $clientId = env('MQTT_FLOWCLIENT_ID');

            // Instantiate MQTT client
            $mqtt = new MqttClient($host, $port, $clientId);
            $connectionSettings = (new ConnectionSettings)
                ->setUsername($username)
                ->setPassword($password)
                ->setKeepAliveInterval(60);

            // Log connection attempt
            Log::info('Attempting to connect to MQTT broker', ['host' => $host, 'port' => $port]);

            // Connect to the broker
            $mqtt->connect($connectionSettings, true);

            // Log successful connection
            Log::info('Connected to MQTT broker');

            // Log publishing attempt
            Log::info('Publishing message to MQTT topic', ['topic' => $topic, 'message' => $interval]);

            // Publish the message
            $mqtt->publish($topic, strval($interval), 0);

            // Log successful publication
            Log::info('Message published successfully');

            // Disconnect from the broker
            $mqtt->disconnect();

            // Log disconnection
            Log::info('Disconnected from MQTT broker');

            // Redirect with success message
            return response()->json(['message' => 'Flow updated successfully']);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to update flow: ' . $e->getMessage());

            // Handle connection or publishing errors
            return response()->json(['error' => 'Failed to update flow: ' . $e->getMessage()], 500);
        }
    }

}