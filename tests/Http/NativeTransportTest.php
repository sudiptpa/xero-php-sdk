<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Exceptions\TransportException;
use Sujip\Xero\Exceptions\ValidationException;
use Sujip\Xero\Http\NativeTransport;
use Sujip\Xero\Http\Request;

/**
 * NativeTransport is the one class that genuinely talks to the network, so it
 * is exercised against a real throwaway loopback HTTP server (php -S in a child
 * process) rather than a mock. The code under test runs in this process and is
 * instrumented normally; only the peer it talks to is external. This is the
 * deliberate exception to the "always FakeTransport" convention — you cannot
 * cover the real cURL adapter by substituting a fake for it.
 */
final class NativeTransportTest extends TestCase
{
    /** @var resource|null */
    private static $process = null;

    private static string $baseUri = '';

    public static function setUpBeforeClass(): void
    {
        $docroot = sys_get_temp_dir() . '/xero-native-transport-' . uniqid('', true);
        mkdir($docroot);
        file_put_contents($docroot . '/router.php', self::routerScript());

        $port = self::findFreePort();
        self::$baseUri = "http://127.0.0.1:{$port}";

        $command = [PHP_BINARY, '-S', "127.0.0.1:{$port}", $docroot . '/router.php'];

        $process = proc_open(
            $command,
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes
        );

        if (! is_resource($process)) {
            self::fail('Unable to start the loopback HTTP server.');
        }

        self::$process = $process;
        self::waitForServer($port);
    }

    public static function tearDownAfterClass(): void
    {
        if (is_resource(self::$process)) {
            proc_terminate(self::$process);
            proc_close(self::$process);
            self::$process = null;
        }
    }

    public function test_it_performs_a_get_and_parses_status_headers_and_body(): void
    {
        $response = (new NativeTransport())->send(
            new Request('GET', '/json', headers: ['Accept' => 'application/json'], baseUri: self::$baseUri)
        );

        self::assertSame(200, $response->status);
        self::assertSame('application/json', $response->header('Content-Type'));
        self::assertSame('hello', $response->header('X-Custom'));
        self::assertSame(['Status' => 'OK'], $response->json());
    }

    public function test_it_sends_a_json_body_with_a_content_type_header(): void
    {
        $response = (new NativeTransport())->send(
            new Request('POST', '/echo', json: ['Name' => 'Acme'], baseUri: self::$baseUri)
        );

        self::assertSame(200, $response->status);
        self::assertSame(['Name' => 'Acme'], $response->json());
    }

    public function test_it_sends_a_raw_request_body(): void
    {
        $response = (new NativeTransport())->send(
            new Request('PUT', '/echo', body: 'raw-payload', baseUri: self::$baseUri)
        );

        self::assertSame(200, $response->status);
        self::assertSame('raw-payload', $response->body);
    }

    public function test_it_maps_error_status_codes_to_exceptions(): void
    {
        $this->expectException(ValidationException::class);

        (new NativeTransport())->send(
            new Request('GET', '/boom', baseUri: self::$baseUri)
        );
    }

    public function test_it_throws_a_transport_exception_on_connection_failure(): void
    {
        $this->expectException(TransportException::class);

        // Port 1 has nothing listening — curl_exec() fails at the socket level.
        (new NativeTransport(timeout: 2, connectTimeout: 1))->send(
            new Request('GET', '/json', baseUri: 'http://127.0.0.1:1')
        );
    }

    private static function findFreePort(): int
    {
        $socket = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);

        if ($socket === false) {
            self::fail("Unable to allocate a free port: {$errstr} ({$errno}).");
        }

        $name = stream_socket_get_name($socket, false);
        fclose($socket);

        $port = (int) substr((string) $name, (int) strrpos((string) $name, ':') + 1);

        return $port;
    }

    private static function waitForServer(int $port): void
    {
        $deadline = microtime(true) + 5.0;

        while (microtime(true) < $deadline) {
            $connection = @fsockopen('127.0.0.1', $port, $errno, $errstr, 0.2);

            if (is_resource($connection)) {
                fclose($connection);

                return;
            }

            usleep(50_000);
        }

        self::fail('The loopback HTTP server did not become ready in time.');
    }

    private static function routerScript(): string
    {
        return <<<'PHP'
            <?php

            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            if ($path === '/json') {
                header('Content-Type: application/json');
                header('X-Custom: hello');
                echo json_encode(['Status' => 'OK']);

                return true;
            }

            if ($path === '/echo') {
                header('Content-Type: application/json');
                echo file_get_contents('php://input');

                return true;
            }

            if ($path === '/boom') {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['Message' => 'bad request']);

                return true;
            }

            http_response_code(404);

            return true;
            PHP;
    }
}
