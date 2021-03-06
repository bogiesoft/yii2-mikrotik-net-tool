<?php

namespace PEAR2\Net\RouterOS\Util\Test\Unsafe\NonPersistent;

use PEAR2\Net\RouterOS\Client;
use PEAR2\Net\RouterOS\Util;
use PEAR2\Net\RouterOS\Util\Test\Unsafe\NonPersistent;
use PEAR2\Net\Transmitter\NetworkStream;

require_once __DIR__ . '/../NonPersistent.php';

/**
 * ~
 * 
 * @group Util
 * @group Unsafe
 * @group NonPersistent
 * @group Encrypted
 * 
 * @category Net
 * @package  PEAR2_Net_RouterOS
 * @author   Vasil Rangelov <boen.robot@gmail.com>
 * @license  http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link     http://pear2.php.net/PEAR2_Net_RouterOS
 */
class EncryptedTest extends NonPersistent
{
    protected function setUp($username = USERNAME, $password = PASSWORD)
    {
        $this->util = new Util(
            $this->client = new Client(
                \HOSTNAME,
                $username,
                $password,
                ENC_PORT,
                false,
                null,
                NetworkStream::CRYPTO_TLS
            )
        );
    }
}
