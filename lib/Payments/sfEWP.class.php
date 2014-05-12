<?php
/*
  $Id$

  The PayPal class implements the dynamic encryption of PayPal "buy now"
  buttons using the PHP openssl functions. (This evades the ISP restriction
  on executing the external "openssl" utility.)

  Author: Ivor Durham (ivor.durham@ivor.cc)
  Author/Modified: Dincho Todorov (dincho@xbuv.com)
  Version: 1.1

  Example usage:

  $paypal = new PayPalEWP();

  $paypal->setTempFileDirectory('/tmp');
  $paypal->setCertificate('mycompany_cert.pem', 'mycompany_key.pem');
  $paypal->setCertificateID('ABCDEFGHIJKL');
  $paypal->setPayPalCertificate('paypal_cert_sandbox.pem');

  $parameters = array("cmd" => "_xclick",
              "business" => "sales@mycompany.com",
              "item_name" => "Cat Litter #40",
              "amount" => "12.95",
              "no_shipping" => "1",
              "return" => "http://mycompany.com/paypal_ok.php",
              "cancel_return" => "http://mycompany.com/paypal_cancel.php",
              "no_note" => "1",
              "currency_code" => "USD",
              "bn" => "PP-BuyNowBF"
  );

  $encryptedButton = $paypal->encryptButton($parameters);

  echo <<<END_HTML
  <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_s-xclick">
  <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/x-click-but23.gif" border="0" name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!">
  <input type="hidden" name="encrypted" value="
  -----BEGIN PKCS7-----
  {$encryptedButton}
  -----END PKCS7-----
  ">
  </form>

  END_HTML;
 */

class sfEWP
{
    private $certificate = null; // Certificate resource
    private $certificateFile = null; // Path to the certificate file

    private $privateKey = null; // Private key resource (matching certificate)
    private $privateKeyFile = null; // Path to the private key file

    private $paypalCertificate = null; // PayPal public certificate resource
    private $paypalCertificateFile = null; // Path to PayPal public certificate file

    private $certificateID = null; // ID assigned by PayPal to the $certificate.

    private $tempFileDirectory = null;

    public function __construct()
    {
        $this->setTempFileDirectory('/tmp');
        $this->setCertificate(sfConfig::get('app_paypal_cert_public'), sfConfig::get('app_paypal_cert_private_key'));
        $this->setCertificateID(sfConfig::get('app_paypal_cert_id'));
        $this->setPayPalCertificate(sfConfig::get('app_paypal_cert_public_paypal'));
    }

    /*
    setCertificate: set the client certificate and private key pair.

    $certificateFilename - The path to the client certificate

    $keyFilename - The path to the private key corresponding to the certificate

    Returns: TRUE iff the private key matches the certificate.
   */

    public function setCertificate($certificateFilename, $privateKeyFilename)
    {
        if (is_readable($certificateFilename) && is_readable($privateKeyFilename)) {
            $certificate = openssl_x509_read(file_get_contents($certificateFilename));

            $privateKey = openssl_get_privatekey(file_get_contents($privateKeyFilename));

            if (($certificate !== FALSE) && ($privateKey !== FALSE) && openssl_x509_check_private_key($certificate, $privateKey)) {
                $this->certificate = $certificate;
                $this->certificateFile = $certificateFilename;

                $this->privateKey = $privateKey;
                $this->privateKeyFile = $privateKeyFilename;

                return true;
            }
        }

        throw new sfException('sfEWP: Cannot set certificate: ' . $certificateFilename . ' and private key: ' . $privateKeyFilename);
    }

    /*
    setPayPalCertificate: Sets the PayPal certificate

    $fileName - The path to the PayPal certificate.

    Returns: TRUE iff the certificate is read successfully, FALSE otherwise.
   */

    public function setPayPalCertificate($fileName)
    {
        if (is_readable($fileName)) {
            $certificate = openssl_x509_read(file_get_contents($fileName));

            if ($certificate !== FALSE) {
                $this->paypalCertificate = $certificate;
                $this->paypalCertificateFile = $fileName;

                return true;
            } else {
                throw new sfException('sfEWP(openssl_x509_read): Cannot set paypal certificate to: ' . $fileName);
            }
        } else {
            throw new sfException('sfEWP: Cannot set paypal certificate to: ' . $fileName . ' because the file is not readable');
        }
    }

    /*
    setCertificateID: Sets the ID assigned by PayPal to the client certificate

    $id - The certificate ID assigned when the certificate was uploaded to PayPal
   */

    public function setCertificateID($id)
    {
        $this->certificateID = $id;
    }

    /*
    setTempFileDirectory: Sets the directory into which temporary files are written.

    $directory - Directory in which to write temporary files.

    Returns: TRUE iff directory is usable.
   */

    public function setTempFileDirectory($directory)
    {
        if (is_dir($directory) && is_writable($directory)) {
            $this->tempFileDirectory = $directory;

            return true;
        }

        throw new sfException('sfEWP: Cannot set temp directory');
    }

    /*
    encryptButton: Using the previously set certificates and tempFileDirectory
    encrypt the button information.

    $parameters - Array with parameter names as keys.

    Returns: The encrypted string for the _s_xclick button form field.
   */

    public function encryptFields($parameters)
    {
        // Check encryption data is available.

        if ( is_null($this->certificateID) || is_null($this->certificate) || is_null($this->paypalCertificate)) {
            throw new sfException('sfEWP: Certificate ID or Certificate or Paypal Public Certificates is not set');
        }

        $clearText = '';
        $encryptedText = '';

        // Compose clear text data.

        $clearText = 'cert_id=' . $this->certificateID;

        foreach (array_keys($parameters) as $key) {
            $clearText .= "\n{$key}={$parameters[$key]}";
        }

        $clearFile = tempnam($this->tempFileDirectory, 'clear_');
        $signedFile = preg_replace('/clear/', 'signed', $clearFile);
        $encryptedFile = preg_replace('/clear/', 'encrypted', $clearFile);

        $out = fopen($clearFile, 'wb');
        fwrite($out, $clearText);
        fclose($out);

        if (! openssl_pkcs7_sign($clearFile, $signedFile, $this->certificate, $this->privateKey, array(), PKCS7_BINARY)) {
            throw new sfException('sfEWP: Cannot sign ' . $clearFile . ' with ' . $this->certificateFile);
        }

        $signedData = explode("\n\n", file_get_contents($signedFile));

        $out = fopen($signedFile, 'wb');
        fwrite($out, base64_decode($signedData[1]));
        fclose($out);

        if (! openssl_pkcs7_encrypt($signedFile, $encryptedFile, $this->paypalCertificate, array(), PKCS7_BINARY)) {
            throw new sfException('sfEWP: Cannot encrypt signed file ' . $signedFile . ' with ' . $this->paypalCertificateFile);
        }

        $encryptedData = explode("\n\n", file_get_contents($encryptedFile));

        $encryptedText = $encryptedData[1];

        @unlink($clearFile);
        @unlink($signedFile);
        @unlink($encryptedFile);

        return $encryptedText;
    }
}
