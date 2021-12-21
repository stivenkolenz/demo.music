<?php

// namespace classes\Auth

class Auth extends Functions
{

    public $vk;
    public $oauth;
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $display;
    public $scope;
    public $state;
    public $auth_url;

    public function __construct( $ci = false, $cs = false )
    {
        $this->client_id = $ci;
        $this->client_secret = $cs;
        require_once 'vendor/autoload.php';
        $this->vk = new VK\Client\VKApiClient();
        $this->oauth = new VK\OAuth\VKOAuth();
        $this->state = Functions::getIP();
        $this->redirect_uri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL'];
        // $this->get_auth_url();
    }

    private function get_auth_url()
    {
        $this->auth_url = $this->oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $this->client_id, $this->redirect_uri, $this->display, $this->scope, $this->state);
    }

    public function go()
    {
        $this->display = VK\OAuth\VKOAuthDisplay::PAGE;
        $this->scope = [VK\OAuth\Scopes\VKOAuthUserScope::WALL];
        $this->get_auth_url();
        header("Location: " . $this->auth_url);
        // str_replace( '?' . $_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI'] );
    }

    public function get_data($code)
    {
        $res = $this->oauth->getAccessToken($this->client_id, $this->client_secret, $this->redirect_uri, $code);
        $res = $this->vk->users()->get($res['access_token'], [
            'user_ids' => [$res['user_id']],
            'fields' => ['bdate', 'city', 'country', 'home_town', 'has_photo', 'photo_50', 'photo_100', 'photo_200', 'photo_max',  'domain', 'has_mobile', 'contacts', 'connections', 'timezone', 'screen_name', 'maiden_name']
        ]);

        return $res[0];
    }
}
