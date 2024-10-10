<?php

declare(strict_types=1);

namespace App\Shared\Domain\HttpClient;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface ClientInterface
{
    public function getRequest(string $domain, string $path, array $queryParams = [], array $extraHeaders = []): ResponseInterface;

    public function postRequest(string $domain, string $path, string $body, array $extraHeaders = []): ResponseInterface;

    public function postMultipartRequest(string $domain, string $path, array $body, array $extraHeaders = []): ResponseInterface;

    public function putRequest(string $domain, string $path, string $body, array $extraHeaders = []): ResponseInterface;

    public function deleteRequest(string $domain, string $path, array $extraHeaders = []): ResponseInterface;
}
