<?php

namespace Gandung\JWT\Manager;

use Gandung\Psr7\FileStream;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
class KeyManager implements KeyManagerInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $passphrase;

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function setContentFromCertFile($file)
    {
        $file = $this->stripProtocolNameFromCertFile($file);

        if (!file_exists($file)) {
            throw new \InvalidArgumentException(
                sprintf("Certificate file named '%s' not exists.", $file)
            );
        }

        $stream = new FileStream($file, 'rb');
        $this->setContent($stream->getContents());
    }

    /**
     * {@inheritdoc}
     */
    public function setPassphrase($passphrase = '')
    {
        $this->passphrase = $passphrase;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassphrase()
    {
        return $this->passphrase;
    }

    /**
     * Strip 'file://' from given filename.
     *
     * @param string $file
     * @return string
     */
    private function stripProtocolNameFromCertFile($file)
    {
        return false === strpos($file, 'file://')
            ? $file
            : str_replace('file://', '', $file);
    }
}
