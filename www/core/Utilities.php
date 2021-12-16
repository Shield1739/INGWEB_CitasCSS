<?php

namespace Shield1739\UTP\CitasCss\core;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use PHPMailer\PHPMailer\PHPMailer;
use RangeException;

class Utilities
{
    private const ONLY_FIRST = "^(?:PE|E|N|[23456789]|[23456789](?:A|P)?|1[0123]?|1[0123]?(?:A|P)?)$";
    private const FIRST_AND_BOOK = "^(?:PE|E|N|[23456789]|[23456789](?:AV|PI)?|1[0123]?|1[0123]?(?:AV|PI)?)-?$";
    private const BOOK_AND_TOME = "^(?:PE|E|N|[23456789](?:AV|PI)?|1[0123]?(?:AV|PI)?)-(?:\d{1,4})-?$";
    private const FULL_ID = "^(PE|E|N|[23456789](?:AV|PI)?|1[0123]?(?:AV|PI)?)-(\d{1,4})-(\d{1,6})$";

    private const LETTER = "^PE|E|N$";
    private const NUMBER = "^(1[0123]?|[23456789])?$";
    private const MIXED_ID = "^(1[0123]?|[23456789])(AV|PI)$";

    /**
     * Generate a random string, using a cryptographically secure
     * pseudorandom number generator (random_int)
     *
     * This function uses type hints now (PHP 7+ only), but it was originally
     * written for PHP 5 as well.
     *
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     *
     * @param int $length How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     *
     * @return string
     * @throws \Exception
     */
    public static function random_str(
        int    $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string
    {
        if ($length < 1)
        {
            throw new RangeException("Length must be a positive integer", 500);
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i)
        {
            $pieces [] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    /**
     * https://github.com/merlos/cedula-panama
     *
     * Validates a Panamenial id (Cédula)
     *
     * cedula - is a string
     *
     * @author Juan M. Merlos (@merlos)
     */
    public static function validateCedula(string $cedula)
    {
        $fullValid = sprintf("/^P$|%s|%s|%s|%s/i",
            self::ONLY_FIRST,
            self::FIRST_AND_BOOK,
            self::BOOK_AND_TOME,
            self::FULL_ID);

        if (preg_match($fullValid, $cedula, $matches) === 1)
        {
            if (isset($matches[1]))
            {
                return 1;
            }
        }

        return 0;
    }

    #[ArrayShape(["start" => "string", "end" => "string"])] public static function rangeWorkWeek($datestr): array
    {
        date_default_timezone_set(date_default_timezone_get());
        $dt = strtotime($datestr);
        return array(
            "start" => date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt)),
            "end" => date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next friday', $dt))
        );
    }

    public static function sendMailGoDaddy(string $address, string $subject, string $body)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->SMTPAuth = false;
            $mail->SMTPAutoTLS = false;
            $mail->Port = 25;

            //Recipients
            //$mail->setFrom('citascssutp@gmail.com', 'Citas CSS UTP');
            $mail->setFrom('citascssutp@shield1739.com', 'Citas CSS UTP');
            $mail->addAddress($address);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
        } catch (Exception $e) {

        }
    }
}