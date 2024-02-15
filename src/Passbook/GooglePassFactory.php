<?php

/*
 * This file is part of the Passbook package.
 *
 * (c) Eymen Gunay <eymen@egunay.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Passbook;

use BadMethodCallException;
use Firebase\JWT\JWT;
use Google\Client as GoogleClient;
use Google\Service;
use Google\Service\Walletobjects;

/**
 * GooglePassFactory - Creates Google Wallet passes via the API
 *
 * @author Razvan Grigore <razvan.grigore@vampirebyte.ro>
 * @see https://developers.google.com/wallet/generic/web/prerequisites
 */
class GooglePassFactory
{
    /**
     * An Issuer account is necessary to create and distribute passes for Google Wallet.
     * @see https://goo.gle/wallet-console
     * @var string
     */
    public string $issuerId;

    /**
     * @var string
     */
    public string $classSuffix;

    /**
     * Google Wallet service client.
     */
    protected Walletobjects $service;

    /**
     * @param string $issuerId Google Issuer ID
     * @param string $classSuffix 
     * 
     * Required. The unique identifier for the class. This ID must be unique across all from an issuer.
     * This value needs to follow the format `issuerID.identifier` where `issuerID` is issued by Google and `identifier` is chosen by you.
     * The unique identifier can only include alphanumeric characters, `.`, `_`, or `-`."
     * 
     * @param Client|array $clientOrConfig The client used to deliver requests, or a
     *                                     config array to pass to a new Client instance.
     * @param string|array $credentials
     * 
     * Can be a path to JSON credentials or an array representing those
     * credentials (@see Google\Client::setAuthConfig), or an instance of
     * Google\Auth\CredentialsLoader like Google\Auth\Credentials\ServiceAccountCredentials.
     * 
     * @return void 
     */
    public function __construct(string $issuerId, string $classSuffix, $clientOrConfig, $credentials)
    {
        $this->issuerId = $issuerId;
        $this->classSuffix = $classSuffix;

        // Google\Client configuration
        if (is_array($clientOrConfig)) {
            // application name is included in the User-Agent HTTP header
            $clientOrConfig['application_name'] = 'php-passbook';
            $clientOrConfig['credentials'] = $credentials;
            $clientOrConfig['scopes'] = Walletobjects::WALLET_OBJECT_ISSUER;
        }
  
        $this->service = new Walletobjects($clientOrConfig);
    }

    /**
     * Not implemented. Please use the constructor instead.
     * @throws BadMethodCallException
     */
    public function setClient(GoogleClient $client): self
    {
        throw new \BadMethodCallException('Not implemented');
    }

    /**
     * Return Google API Client
     */
    public function getClient(): GoogleClient
    {
        return $this->service->getClient();
    }

    /**
     * Not implemented. Please use the constructor instead.
     * @throws BadMethodCallException
     */
    public function setService(Service $service): self
    {
        throw new \BadMethodCallException('Not implemented');
    }

    /**
     * Return Google Wallet service client.
     */
    public function getService(): Walletobjects
    {
        return $this->service;
    }
}
