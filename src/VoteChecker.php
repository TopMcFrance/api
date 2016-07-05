<?php

namespace TopMcFrance\Api;

/**
 * Check a code to vote on the site of TopMcFrance before giving a reward for his vote.
 *
 * For each vote on the site TopMcFrance with enabled API. 
 * The site generates a verification code to enter the site.
 * This class allows interogger TopMcFrance the validity of a code.
 *
 * Each generated code is unique to the server and can only be used one time.
 *
 * @author Jérôme Desjardins <hello@jewome62.eu>
 */
class VoteChecker
{
    const HOST_API = 'https://topmcfrance.fr/api.php';
    
    /**
     * Server Id 
     * @var integer 
     */
    protected $serverId;
    
    public function __construct($serverId)
    {
        $this->serverId = $serverId;
        if(!function_exists('curl_version')){
            throw new \RuntimeException('Curl must be install locally');
        }
    }
    
    /**
     * Check if code is valid on TopMcFrance
     * @param string $code
     * @return boolean
     * @throws type
     */
    public function checkCode($code){
        
       $response = $this->getResponse($code);

       if($response->etat === true){
           return true; 
       } else {
           switch ($response->etat){
               case '1' :
                   throw ApiException::alreadyUsed($code, $response);
               case '2' :
                   throw ApiException::invalidCode($code, $response);
               default:
                   throw ApiException::unknowException($code, $response);
           }
       }
    }
    
    /**
     * Retrieve the URI access for checking code
     * @param string $code
     * @return string
     */
    public function buildURI($code){
        return self::HOST_API.'?id_serv='.$this->serverId.'&code='.$code;
    }
    
    /**
     * Return the response for TopMcFrance
     * @param string $code
     * @return string
     */
    protected function getResponse($code){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $this->buildURI($code));

        $result = curl_exec($ch);

        curl_close($ch);
        
        return json_decode($result, true);
    }
    
    
}
