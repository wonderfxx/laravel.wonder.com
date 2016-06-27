<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/18
 * Time: 下午4:01
 */

namespace libraries;

class CommonFunc
{
    protected static $authPasswordSalt = 'zXm1rUgHsLsotB745y';

    /**
     * Generate md5 auth
     *
     * @param        $data 数据
     * @param string $salt 密钥
     *
     * @return string
     */
    public static function makeMd5Auth($data = '', $salt = '')
    {
        if (empty($salt))
        {
            $salt = self::$authPasswordSalt;
        }

        return md5(md5($data) . $salt);
    }

    /**
     * 密码生成器
     *
     * @param int $length
     *
     * @return string
     */
    public static function makeRandomPassword($length = 10)
    {
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
                       'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
                       't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D',
                       'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
                       'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                       '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!',
                       '@', '#', '$', '%', '^', '&', '*', '(', ')', '-', '_',
                       '[', ']', '{', '}', '<', '>', '~', '`', '+', '=', ',',
                       '.', ';', ':', '/', '?', '|');

        $keys     = array_rand($chars, $length);
        $password = '';
        for ($i = 0; $i < $length; $i++)
        {
            $password .= $chars[$keys[$i]];
        }

        return $password;
    }

    /**
     * Curl 远程提交数据
     *
     * @param       $url
     * @param array $data
     * @param int   $timeout
     *
     * @return bool|mixed
     */
    public static function curlRequest($url, $data = array(), $timeout = 10)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        if (!empty($_SERVER['HTTP_USER_AGENT']))
        {
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        }
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if (!empty($data))
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $resultData = curl_exec($curl);
        $httpInfo   = curl_getinfo($curl);

        //记录日志
        $writeLogData = array(
            'urlAddress' => $url,
            'urlData'    => $data,
            'httpCode'   => $httpInfo['http_code'],
            'resultData' => $resultData
        );
        self::writeCurlLog($writeLogData);

        if (curl_errno($curl))
        {
            curl_close($curl);

            return false;
        }
        else
        {
            curl_close($curl);

            return $resultData;
        }
    }

    /**
     * Socket 模拟远程POST/GET请求
     *
     * @param        $urlAddress
     * @param string $data
     * @param bool   $head
     * @param string $port
     * @param string $timeout
     * @param string $contentType
     *
     * @return array
     */
    public static function socketRequest($urlAddress, $data = '', $head = false, $port = '80', $timeout = '10', $contentType = 'application/x-www-form-urlencoded')
    {

        // 处理请求数据
        $url        = parse_url($urlAddress);
        $scheme     = $url['scheme'];
        $host       = $url['host'];
        $path       = !empty($url['path']) ? $url['path'] : '';
        $query      = !empty($url['query']) ? "?" . $url['query'] : '';
        $resultInfo = array('result' => '', 'header' => array());
        $headerInfo = 1;

        // 区分请求协议
        if ($scheme == 'https')
        {
            $socket = fsockopen('ssl://' . $host, 443, $errno, $errstr, $timeout);
        }
        else
        {
            $socket = fsockopen($host, $port, $errno, $errstr, $timeout);
        }

        // POST 配置参数
        if (!empty($data))
        {
            if (is_array($data))
            {
                $data = http_build_query($data);
            }
            $http = "POST $path$query HTTP/1.1\r\n";
            $http .= "Host: $host\r\n";
            if (!empty($_SERVER['HTTP_USER_AGENT']))
            {
                $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            }
            $http .= "Content-Type: $contentType\r\n";
            $http .= "Content-length: " . strlen($data) . "\r\n";
            $http .= "Connection: close\r\n\r\n";
            $http .= $data . "\r\n\r\n";
        }
        else
        {
            $http = "GET $path$query HTTP/1.1\r\n";
            $http .= "Host: $host\r\n";
            if (!empty($_SERVER['HTTP_USER_AGENT']))
            {
                $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            }
            $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
            $http .= "Accept: */*\r\n";
            $http .= "Connection: close\r\n\r\n";
        }

        // 发送头信息 + 获取数据 + 关闭请求
        fwrite($socket, $http);
        while (!feof($socket))
        {
            $line = fgets($socket, 4096);
            if ($headerInfo && ($line == "\n" || $line == "\r\n"))
            {
                $headerInfo = 0;
            }
            else if (!$headerInfo)
            {
                $resultInfo['result'] .= $line;
            }
            else
            {
                $resultInfo['header'][] = $line;
            }
        }
        fclose($socket);

        // 记录请求日志
        $writeLogData = array(
            'urlAddress' => $urlAddress,
            'urlData'    => $data,
            'httpCode'   => !empty($resultInfo['header'][0]) ? $resultInfo['header'][0] : '',
            'resultData' => !empty($resultInfo['result']) ? $resultInfo['result'] : '',
        );
        self::writeCurlLog($writeLogData);

        // 返回数据
        return !empty($head) ? $resultInfo : $resultInfo['result'];
    }

    /**
     * 记录日志
     *
     * @param array $data
     */
    public static function writeCurlLog($data = array())
    {
        \Log::info('curl info:', $data);
    }

    /**
     * 返回所有的国家
     * @return array
     */
    public static function getCountriesCode()
    {
        return [
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, The Democratic Republic of The",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, The Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and The Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and The South Sandwich Islands",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ];
    }

    /**
     * 返回所有的货币
     *
     * @return array
     */
    public static function getCurrenciesCode()
    {
        return [
            //custom code
            "KRD" => "KRD",
            //ios code
            "AFN" => "AFN",
            "EUR" => "EUR",
            "ALL" => "ALL",
            "DZD" => "DZD",
            "USD" => "USD",
            "AOA" => "AOA",
            "XCD" => "XCD",
            "ARS" => "ARS",
            "AMD" => "AMD",
            "AWG" => "AWG",
            "AUD" => "AUD",
            "AZN" => "AZN",
            "BSD" => "BSD",
            "BHD" => "BHD",
            "BDT" => "BDT",
            "BBD" => "BBD",
            "BYN" => "BYN",
            "BYR" => "BYR",
            "BZD" => "BZD",
            "XOF" => "XOF",
            "BMD" => "BMD",
            "INR" => "INR",
            "BTN" => "BTN",
            "BOB" => "BOB",
            "BOV" => "BOV",
            "BAM" => "BAM",
            "BWP" => "BWP",
            "NOK" => "NOK",
            "BRL" => "BRL",
            "BND" => "BND",
            "BGN" => "BGN",
            "BIF" => "BIF",
            "CVE" => "CVE",
            "KHR" => "KHR",
            "XAF" => "XAF",
            "CAD" => "CAD",
            "KYD" => "KYD",
            "CLP" => "CLP",
            "CLF" => "CLF",
            "CNY" => "CNY",
            "COP" => "COP",
            "COU" => "COU",
            "KMF" => "KMF",
            "CDF" => "CDF",
            "NZD" => "NZD",
            "CRC" => "CRC",
            "HRK" => "HRK",
            "CUP" => "CUP",
            "CUC" => "CUC",
            "ANG" => "ANG",
            "CZK" => "CZK",
            "DKK" => "DKK",
            "DJF" => "DJF",
            "DOP" => "DOP",
            "EGP" => "EGP",
            "SVC" => "SVC",
            "ERN" => "ERN",
            "ETB" => "ETB",
            "FKP" => "FKP",
            "FJD" => "FJD",
            "XPF" => "XPF",
            "GMD" => "GMD",
            "GEL" => "GEL",
            "GHS" => "GHS",
            "GIP" => "GIP",
            "GTQ" => "GTQ",
            "GBP" => "GBP",
            "GNF" => "GNF",
            "GYD" => "GYD",
            "HTG" => "HTG",
            "HNL" => "HNL",
            "HKD" => "HKD",
            "HUF" => "HUF",
            "ISK" => "ISK",
            "IDR" => "IDR",
            "XDR" => "XDR",
            "IRR" => "IRR",
            "IQD" => "IQD",
            "ILS" => "ILS",
            "JMD" => "JMD",
            "JPY" => "JPY",
            "JOD" => "JOD",
            "KZT" => "KZT",
            "KES" => "KES",
            "KPW" => "KPW",
            "KRW" => "KRW",
            "KWD" => "KWD",
            "KGS" => "KGS",
            "LAK" => "LAK",
            "LBP" => "LBP",
            "LSL" => "LSL",
            "ZAR" => "ZAR",
            "LRD" => "LRD",
            "LYD" => "LYD",
            "CHF" => "CHF",
            "MOP" => "MOP",
            "MKD" => "MKD",
            "MGA" => "MGA",
            "MWK" => "MWK",
            "MYR" => "MYR",
            "MVR" => "MVR",
            "MRO" => "MRO",
            "MUR" => "MUR",
            "XUA" => "XUA",
            "MXN" => "MXN",
            "MXV" => "MXV",
            "MDL" => "MDL",
            "MNT" => "MNT",
            "MAD" => "MAD",
            "MZN" => "MZN",
            "MMK" => "MMK",
            "NAD" => "NAD",
            "NPR" => "NPR",
            "NIO" => "NIO",
            "NGN" => "NGN",
            "OMR" => "OMR",
            "PKR" => "PKR",
            "PAB" => "PAB",
            "PGK" => "PGK",
            "PYG" => "PYG",
            "PEN" => "PEN",
            "PHP" => "PHP",
            "PLN" => "PLN",
            "QAR" => "QAR",
            "RON" => "RON",
            "RUB" => "RUB",
            "RWF" => "RWF",
            "SHP" => "SHP",
            "WST" => "WST",
            "STD" => "STD",
            "SAR" => "SAR",
            "RSD" => "RSD",
            "SCR" => "SCR",
            "SLL" => "SLL",
            "SGD" => "SGD",
            "XSU" => "XSU",
            "SBD" => "SBD",
            "SOS" => "SOS",
            "SSP" => "SSP",
            "LKR" => "LKR",
            "SDG" => "SDG",
            "SRD" => "SRD",
            "SZL" => "SZL",
            "SEK" => "SEK",
            "CHE" => "CHE",
            "CHW" => "CHW",
            "SYP" => "SYP",
            "TWD" => "TWD",
            "TJS" => "TJS",
            "TZS" => "TZS",
            "THB" => "THB",
            "TOP" => "TOP",
            "TTD" => "TTD",
            "TND" => "TND",
            "TRY" => "TRY",
            "TMT" => "TMT",
            "UGX" => "UGX",
            "UAH" => "UAH",
            "AED" => "AED",
            "USN" => "USN",
            "UYU" => "UYU",
            "UYI" => "UYI",
            "UZS" => "UZS",
            "VUV" => "VUV",
            "VEF" => "VEF",
            "VND" => "VND",
            "YER" => "YER",
            "ZMW" => "ZMW",
            "ZWL" => "ZWL",
            "XBA" => "XBA",
            "XBB" => "XBB",
            "XBC" => "XBC",
            "XBD" => "XBD",
            "XTS" => "XTS",
            "XXX" => "XXX",
            "XAU" => "XAU",
            "XPD" => "XPD",
            "XPT" => "XPT",
            "XAG" => "XAG",
        ];
    }
}