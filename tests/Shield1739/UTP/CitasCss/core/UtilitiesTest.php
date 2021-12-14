<?php

namespace Shield1739\UTP\CitasCss\core;

use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

class UtilitiesTest extends TestCase
{
    protected Utilities $utilities;

    public function testRandom_str()
    {
        $length = 6;
        $keyspace = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = Utilities::random_str($length, $keyspace); // Throws exception if length < 0

        assertEquals(6, strlen($str));
        assertEquals(1, preg_match('/^[A-Z]+$/', $str));
    }

    public function testRangeWorkWeek()
    {
        $weekRange1 = Utilities::rangeWorkWeek('2021/12/06');
        $weekRange2 = Utilities::rangeWorkWeek('2021/12/08');
        $weekRange3 = Utilities::rangeWorkWeek('2021/12/14');

        assertEquals('2021-12-06', $weekRange1['start']);
        assertEquals('2021-12-10', $weekRange1['end']);
        assertEquals('2021-12-06', $weekRange2['start']);
        assertEquals('2021-12-10', $weekRange2['end']);
        assertEquals('2021-12-13', $weekRange3['start']);
        assertEquals('2021-12-17', $weekRange3['end']);
    }

    public function testValidateCedula()
    {
        assertEquals(1, Utilities::validateCedula("8-1234-12345"));
        assertEquals(1, Utilities::validateCedula("PE-1234-12345"));
        assertEquals(1, Utilities::validateCedula("E-8-102017"));
        assertEquals(1, Utilities::validateCedula("N-1234-12345"));
        assertEquals(1, Utilities::validateCedula("E-1234-12345"));
        assertEquals(1, Utilities::validateCedula("E-1234-12345"));

        assertEquals(0, Utilities::validateCedula(""));
        assertEquals(0, Utilities::validateCedula("1"));
        assertEquals(0, Utilities::validateCedula("111"));
        assertEquals(0, Utilities::validateCedula("A"));
        assertEquals(0, Utilities::validateCedula("P-"));
        assertEquals(0, Utilities::validateCedula("16-"));
        assertEquals(0, Utilities::validateCedula("14-1244"));
        assertEquals(0, Utilities::validateCedula("12-1234-1234567"));
    }
}
