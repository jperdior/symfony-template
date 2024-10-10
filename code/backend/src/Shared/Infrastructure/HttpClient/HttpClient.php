<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\HttpClient;

use App\Shared\Domain\HttpClient\ClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClient implements ClientInterface
{
    private array $headers = [
        'Content-Type: application/ld+json',
        'Accept: application/ld+json',
    ];

    public function __construct(
        private readonly HttpClientInterface $client,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getRequest(string $domain, string $path, array $queryParams = [], array $extraHeaders = []): ResponseInterface
    {
        $this->headers = array_merge($this->headers, $extraHeaders);

        $options = [
            'headers' => $this->headers,
        ];

        if (!empty($queryParams)) {
            $options['query'] = $queryParams;
        }

        $url = $domain.$path;

        return $this->client->request(
            method: 'GET',
            url: $url,
            options: $options,
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function postRequest(
        string $domain,
        string $path,
        string $body,
        array $extraHeaders = []
    ): ResponseInterface {
        $this->headers = array_merge($this->headers, $extraHeaders);

        $options = [
            'headers' => $this->headers,
            'body' => $body,
            'timeout' => 200,
        ];

        $url = $domain.$path;

        return $this->client->request(
            method: 'POST',
            url: $url,
            options: $options
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function postMultipartRequest(
        string $domain,
        string $path,
        array $body,
        array $extraHeaders = []
    ): ResponseInterface {
        $this->headers = array_merge($this->headers, $extraHeaders);

        $options = [
            'headers' => $this->headers,
            'body' => $body,
            'timeout' => 200,
        ];

        $url = $domain.$path;

        return $this->client->request(
            method: 'POST',
            url: $url,
            options: $options
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function putRequest(string $domain, string $path, string $body, array $extraHeaders = []): ResponseInterface
    {
        $this->headers = array_merge($this->headers, $extraHeaders);

        $options = [
            'headers' => $this->headers,
            'body' => $body,
            'timeout' => 200,
        ];

        $url = $domain.$path;

        return $this->client->request(
            method: 'PUT',
            url: $url,
            options: $options
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function deleteRequest(string $domain, string $path, array $extraHeaders = []): ResponseInterface
    {
        $this->headers = array_merge($this->headers, $extraHeaders);

        $options = [
            'headers' => $this->headers,
            'timeout' => 200,
        ];

        $url = $domain.$path;

        return $this->client->request(
            method: 'DELETE',
            url: $url,
            options: $options
        );
    }
}
