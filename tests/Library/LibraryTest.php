<?php

namespace App\Controller;

require_once __DIR__ . '/../../src/Controller/LibraryController.php';


use PHPUnit\Framework\TestCase;

class LibraryControllerTest extends TestCase
{
    private function createBook()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/book/create');

        $form = $crawler->filter('form[name="book"]')->form();
        $form['title'] = 'Test Book';
        $form['isbn'] = '1234567890';
        $form['author'] = 'John Doe';
        
        $imagePath = '/path/to/image.jpg'; // Replace with the actual image path
        
        $form['image']->upload($imagePath);

        $client->submit($form);

        return $client->getCrawler();
    }

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/library');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'LibraryController');
    }

    public function testCreateBook()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/book/create');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('form[name="book"]');
        
        // Add additional assertions for form submission and book creation
    }

    public function testShowAllBooks()
    {
        $client = static::createClient();
        $client->request('GET', '/book/show/all');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('.book-list');
    }

    public function testShowBook()
    {
        $client = static::createClient();
        $client->request('GET', '/book/show/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('.book-details');
    }

    public function testDeleteBook()
    {
        $crawler = $this->createBook();
        $bookId = $crawler->filter('.book-details')->attr('data-book-id');

        $client = static::createClient();
        $client->request('GET', '/book/delete/' . $bookId);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/book/show/all'));
    }

    public function testUpdateBook()
    {
        $crawler = $this->createBook();
        $bookId = $crawler->filter('.book-details')->attr('data-book-id');

        $client = static::createClient();
        $crawler = $client->request('GET', '/book/update/' . $bookId);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('form[name="book"]');
        
        // Add additional assertions for form submission and book update
    }

    public function testResetDatabase()
    {
        $client = static::createClient();
        $client->request('GET', '/library/reset');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertTrue($client->getResponse()->isRedirect('/book/show/all'));
    }
}