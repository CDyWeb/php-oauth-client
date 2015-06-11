<?php

/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Lesser General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Lesser General Public License for more details.
 *
 *  You should have received a copy of the GNU Lesser General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace fkooman\OAuth\Client;

use Guzzle\Http\Client;
use Guzzle\Plugin\CurlAuth\CurlAuthPlugin;

/**
 * Http Client Implementation using Guzzle 3.
 */
class Guzzle3Client implements HttpClientInterface
{
    /** @var Guzzle\Http\Client */
    private $client;

    public function __construct(Client $client = null)
    {
        if (null === $client) {
            $client = new Client();
        }
        $this->client = $client;
    }

    public function setBasicAuth($user, $pass)
    {
        $this->client->addSubscriber(new CurlAuthPlugin($user, $pass));
        return $this;
    }

    public function post($url, $postFields, $headers)
    {
        $request = $this->client->post($url);
        $request->addPostFields($postFields);
        foreach ($headers as $k => $v) {
            $request->addHeader($k, $v);
        }

        return $request->send()->json();
    }
}
