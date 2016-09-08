<?php

namespace TopMcFrance\Api;

/**
 * Provide exception when the check code isn't valid
 *
 * @author Jérôme Desjardins <hello@jewome62.eu>
 */
class ApiException extends \Exception
{
    protected $useDate = null;
    
    protected $apiMessage = null;
    
    protected $apiCodeError = 0;
    
    /**
     * Return the date of use for already use exception
     * @return string
     */
    public function getUseDate()
    {
        return $this->useDate;
    }
    
    /**
     * get api message error
     * @return string
     */
    public function getApiMessage()
    {
        return $this->apiMessage;
    }

    /**
     * Get api code error
     * @return string
     */
    public function getApiCodeError()
    {
        return $this->apiCodeError;
    }
 
    /**
     * Exception if code already use
     * @param string $code
     * @param mixed $response
     * @return \self
     */
    public static function alreadyUsed($code, $response){
        $exception = new self(sprintf('Code %s has already used at %s.',
            $code,
            $response->use_date
        ));
        
        $exception->useDate = $response->use_date;
        $exception->baseException($response);
        
        return $exception;
    }
    
    /**
     * Exception if code isn't valid
     * @param string $code
     * @param mixed $response
     * @return \self
     */
    public static function invalidCode($code, $response){
        $exception = new self(sprintf('Code %s isn\'t valid.',
            $code
        ));
         
        $exception->baseException($response);
        
        return $exception;
    }
    
    /**
     * Exception if unknow code
     * @param mixed $response
     * @return \self
     */
    public static function unknowException($message, $response){
        $exception = new self(sprintf('Unknow code error : %s.',
            $message
        ));
         
        $exception->baseException($response);
        
        return $exception;
    } 
    
    private function baseException($response){
        $this->apiCodeError = $response->erreur;
        $this->apiMessage = $response->detail;
    }
}
