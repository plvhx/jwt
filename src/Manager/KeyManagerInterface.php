<?php

namespace Gandung\JWT\Manager;

/**
 * @author Paulus Gandung Prakosa <rvn.plvhx@gmail.com>
 */
interface KeyManagerInterface
{
    /**
     * Set key content.
     *
     * @param string $content
     * @return void
     */
    public function setContent($content);

    /**
     * Get key content.
     *
     * @return string
     */
    public function getContent();

    /**
     * Set key content from given filename.
     *
     * @param string $file
     * @return void
     */
    public function setContentFromCertFile($file);

    /**
     * Set key passphrase.
     *
     * @param string $passphrase
     * @return void
     */
    public function setPassphrase($passphrase);

    /**
     * Get key passphrase.
     *
     * @return string
     */
    public function getPassphrase();
}
