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

        $result = file_get_contents($this->buildURI($code));

        if($result === false){
             throw new \Exception("Impossible to accès to TopMcFrance");
        }
        return json_decode($result);
    }
    
    
}
