<?php
include realpath(__DIR__ . "/../libraries/Request/Requests.php");
/**
 * Class Notelr_API
 */
class Notelr_API
{
    /**
     * The endpoint to which to connect
     * @var string
     */
    private $endpoint = "http://notelr.com/api/";

    /**
     * The key to use when making calls
     * @var null
     */
    private $key = null;

    /**
     * @param null $key
     */
    public function __construct($key = null)
    {
        if (isset($key)) {
            $this->key = $key;
        }
        Requests::register_autoloader();
    }

    /**
     * Login a user
     * @param $email
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function login($email, $password)
    {
        $url = $this->endpoint . "login";
        $response = Requests::post(
            $url,
            array(),
            array(
                'email' => $email,
                'password' => $password
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Get user widgets
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getWidgets($id)
    {
        $url = $this->endpoint . "get-widgets";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Send confirmation email
     * @param $email
     * @return mixed
     * @throws Exception
     */
    public function sendEmail($email)
    {
        $url = $this->endpoint . "send-confirmation";
        $response = Requests::post(
            $url,
            array(),
            array(
                'email' => $email
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Create a new user
     * @param $id
     * @param $name
     * @param $username
     * @param $password
     * @return mixed
     * @throws Exception
     */
    public function registerUser($id, $name, $username, $password)
    {
        $url = $this->endpoint . "create-user";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'name' => $name,
                'username' => $username,
                'password' => $password,
                'key' => $this->key
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Get user stats
     * @param $id
     * @param $type
     * @param $period
     * @return mixed
     * @throws Exception
     */
    public function getStats($id, $type, $period)
    {
        $url = $this->endpoint . "get-stats";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key,
                'type' => $type,
                'period' => $period
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Save a new or existing widget
     * @param $id
     * @param $type
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function saveWidget($id, $type, $data)
    {
        $url = $this->endpoint . "save-widget";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key,
                'type' => $type,
                'data' => $data
            )
        );

        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Get an existing widget
     * @param $id
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function getWidget($id, $type)
    {
        $url = $this->endpoint . "get-widget";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key,
                'type' => $type
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Delete a widget
     * @param $id
     * @param $type
     * @return mixed
     * @throws Exception
     */
    public function deleteWidget($id, $type)
    {
        $url = $this->endpoint . "delete-widget";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key,
                'type' => $type
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Get the user Paypal email
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function getPaypalEmail($id)
    {
        $url = $this->endpoint . "get-paypal-email";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Set the user Paypal email
     * @param $id
     * @param $email
     * @return mixed
     * @throws Exception
     */
    public function setPaypalEmail($id, $email)
    {
        $url = $this->endpoint . "set-paypal-email";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id,
                'key' => $this->key,
                'email' => $email
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Resend confirmation email
     * @param $id
     * @return mixed
     * @throws Exception
     */
    public function resendEmail($id)
    {
        $url = $this->endpoint . "resend-confirmation";
        $response = Requests::post(
            $url,
            array(),
            array(
                'id' => $id
            )
        );
        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }

    /**
     * Get a widget products
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function getProducts($data)
    {

        $params = array();
        if (!empty($data['nrProducts'])) {
            $params['nrProducts'] = $data['nrProducts'];
        }
        if (!empty($data['location'])) {
            $params['location'] = $data['location'];
        }
        if (!empty($data['movieId'])) {
            $params['movieId'] = $data['movieId'];
        }
        if (!empty($data['keywords'])) {
            $params['keywords'] = $data['keywords'];
        }
        switch ($data['type']) {
            case "amazon":
                $url = "get-amazon-products";
                break;
            case "ebay":
                $url = "get-ebay-products";
                break;
            case "gilt":
                $url = "get-gilt-products";
                break;
            case "flixster":
                if (!empty($params['movieId'])) {
                    $url = "get-flixster-product";
                } else {
                    $url = "get-flixster-products";
                }
                break;
            case "travelNow":
                $url = "get-travel-now-products";
                break;
        }

        $params['key'] = $this->key;
        $url = $this->endpoint . $url;
        $response = Requests::post(
            $url,
            array(),
            $params
        );

        if ($response->status_code != 200) {
            throw new Exception("Server response error!");
        }
        return json_decode($response->body, true);
    }
} 