<?php

namespace Tests\TopMcFrance\Api;

use PHPUnit\Framework\TestCase;
use TopMcFrance\Api\VoteChecker;
use TopMcFrance\Api\ApiException;

/**
 * @author Jérôme Desjardins <hello@jewome62.eu>
 */
class VoteCheckerTest extends TestCase
{
    
    public function testCheckGoodCodeReturnTrue()
    {
        $vote = new VoteChecker(0);
        $this->assertTrue($vote->checkCode('istrue'));
    }
    
    public function testCheckCodeAlreadyUsedThrowException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Code alreadyused has already used at 0000-00-00 00:00:00');
        
        $vote = new VoteChecker(0);
        $vote->checkCode('alreadyused');
    }
    
     public function testCheckCodeInvalidUsedThrowException()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Code invalidcode isn\'t valid.');
        
        $vote = new VoteChecker(0);
        $vote->checkCode('invalidcode');
        
        
    } 
}
