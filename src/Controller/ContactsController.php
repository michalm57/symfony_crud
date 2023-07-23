<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class ContactsController extends AbstractController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    #[Route('/contacts', name: 'app_contacts')]
    public function index(): Response
    {
        $sql = "SELECT * FROM contacts";
        $contacts = $this->connection->fetchAllAssociative($sql);

        return $this->render('contacts/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
