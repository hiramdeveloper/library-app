<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
	
class CSystemToken
{
	/**
     * Revisa el Token de la session
     *
     * @return string
     */
	static public function chkTokenSession($token){
		
	}

	/**
     * Generates a highly-random ID
     *
     * @return string
     */
	public static function GenerateToken() {
        $result = '';

        $alphabet = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0; $i < 10; ++$i) {
            $result .= $alphabet[mt_rand(0, strlen($alphabet) - 1)];
        }
        $result.='-';
        for ($i = 0; $i < 5; ++$i) {
            $result .= $alphabet[mt_rand(0, strlen($alphabet) - 1)];
        }
        $result.='-';
        for ($i = 0; $i < 5; ++$i) {
            $result .= $alphabet[mt_rand(0, strlen($alphabet) - 1)];
        }
        $result.='-';
        for ($i = 0; $i < 10; ++$i) {
            $result .= $alphabet[mt_rand(0, strlen($alphabet) - 1)];
        }

        return $result;
    }
}
