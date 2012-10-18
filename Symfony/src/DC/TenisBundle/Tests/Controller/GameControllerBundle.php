<?php

namespace DC\TenisBundle\Tests\Controller;

use DC\TenisBundle\Tests\Factory\MatchFactory;


class GameControllerTest extends UsefulTestCase
{
    public function testIShouldStartAMatch()
    {
    	// Arrange
    	// Act
    	$this->startANewMatchThroughInterface();

    	// Assert
    	$this->assertTrue($this->client->getResponse()->isSuccessful());
    }


    public function testItShouldCreateMatches() {
    	// Arrange
    	$this->truncateTables(array('matches'));

    	// Act
    	$this->startANewMatchThroughInterface();

    	//Assert
    	$games = $this->em->getRepository('DCTenisBundle:Match')->findAll();
    	$this->assertEquals(1, count($games));
    }


    public function testIShouldAccessToAMatch() {
    	// Arrange
    	$match = MatchFactory::create($this->em);

    	// Act
    	$this->client->request('GET', '/tenis/' . $match->getId());

		// Assert
    	$this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testIShouldStartAGameInAMatch() {
    	// Arrange
    	$match = MatchFactory::create($this->em);
    	$crawler = $this->client->request('GET', '/tenis/' . $match->getId());
    	$link = $crawler->filter('a#start-game')->link();

    	// Act
    	$this->client->click($link);

    	// Assert
    	$this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /*
    public function testItShouldCreateGamesInMatches() {
    	// Arrange

    	// Act

    	// Assert
    }
     */


	private function startANewMatchThroughInterface() {
    	$crawler = $this->client->request('GET', '/tenis');
		$link = $crawler->filter('a#start-match')->link();
    	$this->client->click($link);
	}
}
