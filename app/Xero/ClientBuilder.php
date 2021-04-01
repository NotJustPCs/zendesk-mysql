<?php


namespace App\Xero;

use App\Helpers\Xero;
use App\Helpers\Zendesk;
use Http\Client\{
    Common\HttpMethodsClient,
    Common\Plugin\AddHostPlugin,
    Common\Plugin\AddPathPlugin,
    Common\Plugin\AuthenticationPlugin,
    Common\Plugin\HeaderSetPlugin,
    Common\PluginClient,
    HttpClient,
};
use Http\Message\Authentication\Header;
use Psr\Http\Message\{
    RequestFactoryInterface,
    StreamFactoryInterface,
    UriFactoryInterface,
};
use Http\Discovery\{
    Psr17FactoryDiscovery,
    Psr18ClientDiscovery,
};
use RuntimeException;


class ClientBuilder
{
    private $Endpoint;
    private $httpClient;
    private $requestFactory;
    private $uriFactory;
    private $streamFactory;

    public function __construct(
        ?HttpClient $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?UriFactoryInterface $uriFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUriFactory();
        $this->streamFactory = $streamFactory ?? Psr17FactoryDiscovery::findStreamFactory();
    }

    public function createClientV2()
    {
        
        $this->create();
    }

    public function create(): Client
    {
       
        $provider = (new Xero())->getXeroOauth2Provider();
        if (!isset($_GET['code'])) {

            $options = [
                'scope' => ['openid email profile offline_access assets projects accounting.settings accounting.transactions accounting.contacts accounting.journals.read accounting.reports.read accounting.attachments']
            ];
    
            // Fetch the authorization URL from the provider; this returns the urlAuthorize option and generates and applies any necessary parameters (e.g. state).
            $authorizationUrl = $provider->getAuthorizationUrl($options);
            // Get the state generated for you and store it to the session.
            
            // $_SESSION['oauth2state'] = $provider->getState();
            request()->session()->put('oauth2state',$provider->getState());
            // Redirect the user to the authorization URL.
            header('Location: ' . $authorizationUrl);
            exit();
    
        // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            exit('Unable to authenticate');
        }
    }
}
