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

namespace SSRSTest\Soap;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;

class NTLMTest extends \PHPUnit_Framework_TestCase {

    public function testFetchWSDLCallsCurlWithUri() {
        $arguments = array(
            'http://localhost/soap/ms.wsdl.xml',
            array(
                'username' => 'test',
                'password' => 'test1'
            )
        );

        $SOAP = $this->getMock('SSRS\Soap\NTLM', array('callCurl'), $arguments);

        $SOAP->expects($this->once())
                ->method('callCurl')
                ->with($this->equalTo('http://localhost/soap/ms.wsdl.xml'));

        $SOAP->fetchWSDL();
    }

    public function testSetUsernameReturnsInstance() {
        $SOAP = new \SSRS\Soap\NTLM('http://');
        $result = $SOAP->setUsername('test');

        $this->assertEquals($SOAP, $result);
        $this->assertInstanceOf('SSRS\Soap\NTLM', $result);
    }

    public function testSetPasswordReturnsInstance() {
        $SOAP = new \SSRS\Soap\NTLM('http://');
        $result = $SOAP->setPassword('test1');

        $this->assertEquals($SOAP, $result);
        $this->assertInstanceOf('SSRS\Soap\NTLM', $result);
    }

    /**
     * @expectedException \SSRS\Soap\Exception
     */
    public function testSetCacheThrowsExceptionWithInvalidPath() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));

        $SOAP = new \SSRS\Soap\NTLM('http://');
        $SOAP->setCachePath(vfsStream::url('tmp/missing/file.wsdl'));
    }

    public function testSetCacheIsSetWithWriteableDirectory() {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));

        $SOAP = new \SSRS\Soap\NTLM('http://');
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

        $SOAP = $this->getMock('SSRS\Soap\NTLM', array('setCacheWSDLPermission'), array('http://'));

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
        $SOAP = $this->getMock('SSRS\Soap\NTLM', array('setCacheWSDLPermission'), array('http://'));

        $SOAP->expects($this->once())
                ->method('setCacheWSDLPermission')
                ->with($this->equalTo(0666));

        $SOAP->setCachePath(vfsStream::url('tmp/file.wsdl'))
                ->cacheWSDL('$fileContents');
    }

}
