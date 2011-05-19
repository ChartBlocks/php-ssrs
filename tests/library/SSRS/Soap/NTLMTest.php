<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SSRS_Soap_NTLMTest
 *
 * @author Andrew Lowe
 */
require_once('SSRS/Soap/NTLM.php');
require_once('SSRS/Soap/Exception.php');
require_once('vfsStream/vfsStream.php');

class SSRS_Soap_NTLMTest extends PHPUnit_Framework_TestCase {

    public function testFetchWSDLCallsCurlWithUri() {
        $arguments = array(
            'http://localhost/soap/ms.wsdl.xml',
            array(
                'username' => 'test',
                'password' => 'test1'
            )
        );

        $SOAP = $this->getMock('SSRS_Soap_NTLM', array('callCurl'), $arguments);

        $SOAP->expects($this->once())
                ->method('callCurl')
                ->with($this->equalTo('http://localhost/soap/ms.wsdl.xml'));

        $SOAP->fetchWSDL();
    }

    public function testSetUsernameReturnsInstance() {
        $SOAP = new SSRS_Soap_NTLM('http://');
        $result = $SOAP->setUsername('test');

        $this->assertEquals($SOAP, $result);
        $this->assertInstanceOf('SSRS_Soap_NTLM', $result);
    }

    public function testSetPasswordReturnsInstance() {
        $SOAP = new SSRS_Soap_NTLM('http://');
        $result = $SOAP->setPassword('test1');

        $this->assertEquals($SOAP, $result);
        $this->assertInstanceOf('SSRS_Soap_NTLM', $result);
    }

    /**
     * @expectedException SSRS_Soap_Exception
     */
    public function testSetCacheThrowsExceptionWithInvalidPath() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));

        $SOAP = new SSRS_Soap_NTLM('http://');
        $SOAP->setCachePath(vfsStream::url('tmp/missing/file.wsdl'));
    }

    public function testSetCacheIsSetWithWriteableDirectory() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));

        $SOAP = new SSRS_Soap_NTLM('http://');
        $SOAP->setCachePath(vfsStream::url('tmp/file.wsdl'));

        $this->assertEquals('vfs://tmp/file.wsdl', $SOAP->getCachePath());
    }

    /**
     * @depends testSetCacheIsSetWithWriteableDirectory
     */
    public function testCacheWSDLIsOutputtedValid() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));
        $content = 'Hesaklk;k;dfs';

        $SOAP = $this->getMock('SSRS_Soap_NTLM', array('setCacheWSDLPermission'), array('http://'));

        $SOAP->expects($this->once())
                ->method('setCacheWSDLPermission');

        $SOAP->setCachePath(vfsStream::url('tmp/file.wsdl'));
        $SOAP->cacheWSDL($content);
        $output = $SOAP->getCacheWSDL();
        $this->assertEquals($output, $content);
    }

    public function testCacheWSDLIsWorldWritable() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));
        $SOAP = $this->getMock('SSRS_Soap_NTLM', array('setCacheWSDLPermission'), array('http://'));

        $SOAP->expects($this->once())
                ->method('setCacheWSDLPermission')
                ->with($this->equalTo(0666));

        $SOAP->setCachePath(vfsStream::url('tmp/file.wsdl'))
                ->cacheWSDL('$fileContents');
    }

}
