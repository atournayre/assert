<?php

namespace Atournayre\Assert\Tests;

use Atournayre\Assert\Assert;
use PHPUnit\Framework\TestCase;

class AssertTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     */
    public function testIsListOfString(): void
    {
        try {
            Assert::isListOf(['1'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function testIsNotListOfStringThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isListOf(['1', new \stdClass()], Assert::TYPE_STRING);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testIsMapOfString(): void
    {
        try {
            Assert::isMapOf(['a' => 'a'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function testIsNotMapOfStringThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        Assert::isMapOf(['a' => 'a', 'b' => new \stdClass()], Assert::TYPE_STRING);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeString(): void
    {
        try {
            Assert::allIsType(['1'], Assert::TYPE_STRING);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeInt(): void
    {
        try {
            Assert::allIsType([1], Assert::TYPE_INT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeFloat(): void
    {
        try {
            Assert::allIsType([1.0], Assert::TYPE_FLOAT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeBool(): void
    {
        try {
            Assert::allIsType([true], Assert::TYPE_BOOL);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeArray(): void
    {
        try {
            Assert::allIsType([[]], Assert::TYPE_ARRAY);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeNull(): void
    {
        try {
            Assert::allIsType([null], Assert::TYPE_NULL);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function testAllIsTypeObject(): void
    {
        try {
            Assert::allIsType([new \stdClass()], Assert::TYPE_OBJECT);
            $this->assertTrue(true);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    public function testBICValid()
    {
        $validBics = [
            ['ASPKAT2LXXX'],
            ['ASPKAT2L'],
            ['DSBACNBXSHA'],
            ['UNCRIT2B912'],
            ['DABADKKK'],
            ['RZOOAT2L303'],
        ];

        self::assertNoExceptions($validBics, function ($bic) {
            Assert::isBIC($bic);
        });
    }

    public function testBICInvalid()
    {
        $invalidBics = [
            'DEUTD',
            'ASPKAT2LXX',
            'ASPKAT2LX',
            'ASPKAT2LXXX1',
            'DABADKK',
            '1SBACNBXSHA',
            'RZ00AT2L303',
            'D2BACNBXSHA',
            'DS3ACNBXSHA',
            'DSB4CNBXSHA',
            'DEUT12HH',
            'DSBAC6BXSHA',
            'DSBA5NBXSHA',
            'DSBAAABXSHA',
            'THISSVAL1D]',
            'DEUTDEF]',
            'DeutAT2LXXX',
            'DEUTAT2lxxx',
        ];

        self::assertExceptions(
            $invalidBics,
            'This is not a valid Business Identifier Code (BIC).',
            function ($bic) {
                Assert::isBIC($bic);
            }
        );
    }

    public function testIBANValid()
    {
        $validIBANs = [
            ['CH9300762011623852957'], // Switzerland without spaces
            ['CH93  0076 2011 6238 5295 7'], // Switzerland with multiple spaces

            // Country list
            // http://www.rbs.co.uk/corporate/international/g0/guide-to-international-business/regulatory-information/iban/iban-example.ashx

            ['AL47 2121 1009 0000 0002 3569 8741'], // Albania
            ['AD12 0001 2030 2003 5910 0100'], // Andorra
            ['AT61 1904 3002 3457 3201'], // Austria
            ['AZ21 NABZ 0000 0000 1370 1000 1944'], // Azerbaijan
            ['BH67 BMAG 0000 1299 1234 56'], // Bahrain
            ['BE62 5100 0754 7061'], // Belgium
            ['BA39 1290 0794 0102 8494'], // Bosnia and Herzegovina
            ['BG80 BNBG 9661 1020 3456 78'], // Bulgaria
            ['BY 13 NBRB 3600 900000002Z00AB00'], // Belarus
            ['BY13 NBRB 3600 900000002Z00AB00'], // Belarus
            ['BY22NB23324232T78YR7823HR32U'], // Belarus
            ['HR12 1001 0051 8630 0016 0'], // Croatia
            ['CY17 0020 0128 0000 0012 0052 7600'], // Cyprus
            ['CZ65 0800 0000 1920 0014 5399'], // Czech Republic
            ['DK50 0040 0440 1162 43'], // Denmark
            ['EE38 2200 2210 2014 5685'], // Estonia
            ['FO97 5432 0388 8999 44'], // Faroe Islands
            ['FI21 1234 5600 0007 85'], // Finland
            ['FR14 2004 1010 0505 0001 3M02 606'], // France
            ['GE29 NB00 0000 0101 9049 17'], // Georgia
            ['DE89 3704 0044 0532 0130 00'], // Germany
            ['GI75 NWBK 0000 0000 7099 453'], // Gibraltar
            ['GR16 0110 1250 0000 0001 2300 695'], // Greece
            ['GL56 0444 9876 5432 10'], // Greenland
            ['HU42 1177 3016 1111 1018 0000 0000'], // Hungary
            ['IS14 0159 2600 7654 5510 7303 39'], // Iceland
            ['IE29 AIBK 9311 5212 3456 78'], // Ireland
            ['IL62 0108 0000 0009 9999 999'], // Israel
            ['IT40 S054 2811 1010 0000 0123 456'], // Italy
            ['LV80 BANK 0000 4351 9500 1'], // Latvia
            ['LB62 0999 0000 0001 0019 0122 9114'], // Lebanon
            ['LI21 0881 0000 2324 013A A'], // Liechtenstein
            ['LT12 1000 0111 0100 1000'], // Lithuania
            ['LU28 0019 4006 4475 0000'], // Luxembourg
            ['MK072 5012 0000 0589 84'], // Macedonia
            ['MT84 MALT 0110 0001 2345 MTLC AST0 01S'], // Malta
            ['MU17 BOMM 0101 1010 3030 0200 000M UR'], // Mauritius
            ['MD24 AG00 0225 1000 1310 4168'], // Moldova
            ['MC93 2005 2222 1001 1223 3M44 555'], // Monaco
            ['ME25 5050 0001 2345 6789 51'], // Montenegro
            ['NL39 RABO 0300 0652 64'], // Netherlands
            ['NO93 8601 1117 947'], // Norway
            ['PK36 SCBL 0000 0011 2345 6702'], // Pakistan
            ['PL60 1020 1026 0000 0422 7020 1111'], // Poland
            ['PT50 0002 0123 1234 5678 9015 4'], // Portugal
            ['RO49 AAAA 1B31 0075 9384 0000'], // Romania
            ['SM86 U032 2509 8000 0000 0270 100'], // San Marino
            ['SA03 8000 0000 6080 1016 7519'], // Saudi Arabia
            ['RS35 2600 0560 1001 6113 79'], // Serbia
            ['SK31 1200 0000 1987 4263 7541'], // Slovak Republic
            ['SI56 1910 0000 0123 438'], // Slovenia
            ['ES80 2310 0001 1800 0001 2345'], // Spain
            ['SE35 5000 0000 0549 1000 0003'], // Sweden
            ['CH93 0076 2011 6238 5295 7'], // Switzerland
            ['TN59 1000 6035 1835 9847 8831'], // Tunisia
            ['TR33 0006 1005 1978 6457 8413 26'], // Turkey
            ['AE07 0331 2345 6789 0123 456'], // UAE
            ['GB12 CPBK 0892 9965 0449 91'], // United Kingdom

            ['DJ21 0001 0000 0001 5400 0100 186'], // Djibouti
            ['EG38 0019 0005 0000 0000 2631 8000 2'], // Egypt
            ['IQ98 NBIQ 8501 2345 6789 012'], // Iraq
            ['LC55 HEMM 0001 0001 0012 0012 0002 3015'], // Saint Lucia
            ['LY83 0020 4800 0020 1001 2036 1'], // Libya
            ['RU02 0445 2560 0407 0281 0412 3456 7890 1'], // Russia
            ['SC18 SSCB 1101 0000 0000 0000 1497 USD'], // Seychelles
            ['SD21 2901 0501 2340 01'], // Sudan
            ['ST23 0002 0000 0289 3557 1014 8'], // Sao Tome and Principe
            ['SV62 CENR 0000 0000 0000 0070 0025'], // El Salvador

            // Extended country list
            // http://www.nordea.com/Our+services/International+products+and+services/Cash+Management/IBAN+countries/908462.html
            // https://www.swift.com/sites/default/files/resources/iban_registry.pdf
            ['AO06000600000100037131174'], // Angola
            ['AZ21NABZ00000000137010001944'], // Azerbaijan
            ['BH29BMAG1299123456BH00'], // Bahrain
            ['BJ11B00610100400271101192591'], // Benin
            ['BR9700360305000010009795493P1'], // Brazil
            ['BR1800000000141455123924100C2'], // Brazil
            ['VG96VPVG0000012345678901'], // British Virgin Islands
            ['BF42BF0840101300463574000390'], // Burkina Faso
            ['BI4210000100010000332045181'], // Burundi
            ['CM2110003001000500000605306'], // Cameroon
            ['CV64000300004547069110176'], // Cape Verde
            ['FR7630007000110009970004942'], // Central African Republic
            ['CG5230011000202151234567890'], // Congo
            ['CR05015202001026284066'], // Costa Rica
            ['DO28BAGR00000001212453611324'], // Dominican Republic
            ['GT82TRAJ01020000001210029690'], // Guatemala
            ['IR580540105180021273113007'], // Iran
            ['IL620108000000099999999'], // Israel
            ['CI05A00060174100178530011852'], // Ivory Coast
            ['JO94CBJO0010000000000131000302'], // Jordan
            ['KZ176010251000042993'], // Kazakhstan
            ['KW74NBOK0000000000001000372151'], // Kuwait
            ['LB30099900000001001925579115'], // Lebanon
            ['MG4600005030010101914016056'], // Madagascar
            ['ML03D00890170001002120000447'], // Mali
            ['MR1300012000010000002037372'], // Mauritania
            ['MU17BOMM0101101030300200000MUR'], // Mauritius
            ['MZ59000100000011834194157'], // Mozambique
            ['PS92PALS000000000400123456702'], // Palestinian Territory
            ['QA58DOHB00001234567890ABCDEFG'], // Qatar
            ['XK051212012345678906'], // Republic of Kosovo
            ['PT50000200000163099310355'], // Sao Tome and Principe
            ['SA0380000000608010167519'], // Saudi Arabia
            ['SN08SN0100152000048500003035'], // Senegal
            ['TL380080012345678910157'], // Timor-Leste
            ['TN5914207207100707129648'], // Tunisia
            ['TR330006100519786457841326'], // Turkey
            ['UA213223130000026007233566001'], // Ukraine
            ['AE260211000000230064016'], // United Arab Emirates
            ['VA59001123000012345678'], // Vatican City State
        ];

        self::assertNoExceptions($validIBANs, function ($iban) {
            Assert::isIBAN($iban);
        });
    }

    public function testIBANInvalid()
    {
        $invalidIBANs = [
            ['AL47 2121 1009 0000 0002 3569 874'], // Albania
            ['AD12 0001 2030 2003 5910 010'], // Andorra
            ['AT61 1904 3002 3457 320'], // Austria
            ['AZ21 NABZ 0000 0000 1370 1000 194'], // Azerbaijan
            ['AZ21 N1BZ 0000 0000 1370 1000 1944'], // Azerbaijan
            ['BH67 BMAG 0000 1299 1234 5'], // Bahrain
            ['BH67 B2AG 0000 1299 1234 56'], // Bahrain
            ['BE62 5100 0754 7061 2'], // Belgium
            ['BA39 1290 0794 0102 8494 4'], // Bosnia and Herzegovina
            ['BG80 BNBG 9661 1020 3456 7'], // Bulgaria
            ['BG80 B2BG 9661 1020 3456 78'], // Bulgaria
            ['BY 13 NBRB 3600 900000002Z00AB001'], // Belarus
            ['BY 13 NBRB 3600 900000002Z00AB0'], // Belarus
            ['BYRO NBRB 3600 900000002Z00AB0'], // Belarus
            ['BY 13 3600 NBRB 900000002Z00AB05'], // Belarus
            ['HR12 1001 0051 8630 0016 01'], // Croatia
            ['CY17 0020 0128 0000 0012 0052 7600 1'], // Cyprus
            ['CZ65 0800 0000 1920 0014 5399 1'], // Czech Republic
            ['DK50 0040 0440 1162 431'], // Denmark
            ['EE38 2200 2210 2014 5685 1'], // Estonia
            ['FO97 5432 0388 8999 441'], // Faroe Islands
            ['FI21 1234 5600 0007 851'], // Finland
            ['FR14 2004 1010 0505 0001 3M02 6061'], // France
            ['GE29 NB00 0000 0101 9049 171'], // Georgia
            ['DE89 3704 0044 0532 0130 001'], // Germany
            ['GI75 NWBK 0000 0000 7099 4531'], // Gibraltar
            ['GR16 0110 1250 0000 0001 2300 6951'], // Greece
            ['GL56 0444 9876 5432 101'], // Greenland
            ['HU42 1177 3016 1111 1018 0000 0000 1'], // Hungary
            ['IS14 0159 2600 7654 5510 7303 391'], // Iceland
            ['IE29 AIBK 9311 5212 3456 781'], // Ireland
            ['IL62 0108 0000 0009 9999 9991'], // Israel
            ['IT40 S054 2811 1010 0000 0123 4561'], // Italy
            ['LV80 BANK 0000 4351 9500 11'], // Latvia
            ['LB62 0999 0000 0001 0019 0122 9114 1'], // Lebanon
            ['LI21 0881 0000 2324 013A A1'], // Liechtenstein
            ['LT12 1000 0111 0100 1000 1'], // Lithuania
            ['LU28 0019 4006 4475 0000 1'], // Luxembourg
            ['MK072 5012 0000 0589 84 1'], // Macedonia
            ['MT84 MALT 0110 0001 2345 MTLC AST0 01SA'], // Malta
            ['MU17 BOMM 0101 1010 3030 0200 000M URA'], // Mauritius
            ['MD24 AG00 0225 1000 1310 4168 1'], // Moldova
            ['MC93 2005 2222 1001 1223 3M44 5551'], // Monaco
            ['ME25 5050 0001 2345 6789 511'], // Montenegro
            ['NL39 RABO 0300 0652 641'], // Netherlands
            ['NO93 8601 1117 9471'], // Norway
            ['PK36 SCBL 0000 0011 2345 6702 1'], // Pakistan
            ['PL60 1020 1026 0000 0422 7020 1111 1'], // Poland
            ['PT50 0002 0123 1234 5678 9015 41'], // Portugal
            ['RO49 AAAA 1B31 0075 9384 0000 1'], // Romania
            ['SM86 U032 2509 8000 0000 0270 1001'], // San Marino
            ['SA03 8000 0000 6080 1016 7519 1'], // Saudi Arabia
            ['RS35 2600 0560 1001 6113 791'], // Serbia
            ['SK31 1200 0000 1987 4263 7541 1'], // Slovak Republic
            ['SI56 1910 0000 0123 4381'], // Slovenia
            ['ES80 2310 0001 1800 0001 2345 1'], // Spain
            ['SE35 5000 0000 0549 1000 0003 1'], // Sweden
            ['CH93 0076 2011 6238 5295 71'], // Switzerland
            ['TN59 1000 6035 1835 9847 8831 1'], // Tunisia
            ['TR33 0006 1005 1978 6457 8413 261'], // Turkey
            ['AE07 0331 2345 6789 0123 4561'], // UAE
            ['GB12 CPBK 0892 9965 0449 911'], // United Kingdom

            // Extended country list
            ['AO060006000001000371311741'], // Angola
            ['AZ21NABZ000000001370100019441'], // Azerbaijan
            ['BH29BMAG1299123456BH001'], // Bahrain
            ['BJ11B006101004002711011925911'], // Benin
            ['BR9700360305000010009795493P11'], // Brazil
            ['BR1800000000141455123924100C21'], // Brazil
            ['VG96VPVG00000123456789011'], // British Virgin Islands
            ['BF1030134020015400945000643'], // Burkina Faso
            ['BI432010110674441'], // Burundi
            ['CM21100030010005000006053061'], // Cameroon
            ['CV640003000045470691101761'], // Cape Verde
            ['FR76300070001100099700049421'], // Central African Republic
            ['CG52300110002021512345678901'], // Congo
            ['CR05A52020010262840661'], // Costa Rica
            ['CR0515202001026284066'], // Costa Rica
            ['DO28BAGR000000012124536113241'], // Dominican Republic
            ['GT82TRAJ010200000012100296901'], // Guatemala
            ['IR5805401051800212731130071'], // Iran
            ['IL6201080000000999999991'], // Israel
            ['CI05A000601741001785300118521'], // Ivory Coast
            ['JO94CBJO00100000000001310003021'], // Jordan
            ['KZ1760102510000429931'], // Kazakhstan
            ['KW74NBOK00000000000010003721511'], // Kuwait
            ['LB300999000000010019255791151'], // Lebanon
            ['MG46000050300101019140160561'], // Madagascar
            ['ML03D008901700010021200004471'], // Mali
            ['MR13000120000100000020373721'], // Mauritania
            ['MU17BOMM0101101030300200000MUR1'], // Mauritius
            ['MZ590001000000118341941571'], // Mozambique
            ['PS92PALS0000000004001234567021'], // Palestinian Territory
            ['QA58DOHB00001234567890ABCDEFG1'], // Qatar
            ['XK0512120123456789061'], // Republic of Kosovo
            ['PT500002000001630993103551'], // Sao Tome and Principe
            ['SA03800000006080101675191'], // Saudi Arabia
            ['SN12K001001520000256900075421'], // Senegal
            ['TL3800800123456789101571'], // Timor-Leste
            ['TN59142072071007071296481'], // Tunisia
            ['TR3300061005197864578413261'], // Turkey
            ['UA21AAAA1300000260072335660012'], // Ukraine
            ['AE2602110000002300640161'], // United Arab Emirates
            ['VA590011230000123456781'], // Vatican City State
        ];

        self::assertExceptions(
            $invalidIBANs,
            'This is not a valid International Bank Account Number (IBAN).',
            function ($iban) {
                Assert::isIBAN($iban);
            }
        );
    }

    public function testEmailValid()
    {
        $validEmails = [
            ['fabien@symfony.com'],
            ['example@example.co.uk'],
            ['fabien_potencier@example.fr'],
            ['example@example.co..uk'],
            ['{}~!@!@£$%%^&*().!@£$%^&*()'],
            ['example@example.co..uk'],
            ['example@-example.com'],
            ['user-very-long-jlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaa@domain.com'], // 255 characters
            ['user@domain-very-long-jlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaajlaaaaaaaaaaaaaaaaaa.com'], // 255 characters
        ];

        self::assertNoExceptions($validEmails, function ($email) {
            Assert::email($email);
        });
    }

    public function testEmailInvalid()
    {
        $invalidEmails = [
            ['example'],
            ['example@'],
            ['example@localhost'],
            ['foo@example.com bar'],
            ['example@example.'],
            ['example@.fr'],
            ['@example.com'],
            ['example@.'],
            ['example@ '],
            [' example@example.com '],
            [' example @example .com '],
            ['foo@example.com bar']
        ];

        self::assertExceptions(
            $invalidEmails,
            'This value is not a valid email address.',
            function ($email) {
                Assert::email($email);
            }
        );
    }

    private static function assertExceptions(array $datas, string $expectedMessage, callable $method): void
    {
        $countErrors = 0;
        foreach ($datas as $item) {
            try {
                $method($item[0]);
                Assert::$method($item[0]);
            } catch (\Exception $e) {
                self::assertInstanceOf(\InvalidArgumentException::class, $e);
                self::assertEquals($expectedMessage, $e->getMessage());
                $countErrors++;
                continue;
            }
        }
        self::assertEquals(count($datas), $countErrors);
    }

    private static function assertNoExceptions(array $datas, callable $method): void
    {
        foreach ($datas as $item) {
            try {
                $method($item[0]);
                self::assertTrue(true);
            } catch (\InvalidArgumentException $e) {
                throw $e;
            }
        }
    }
}
