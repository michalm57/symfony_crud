<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
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

    #[Route('/contacts/create', name: 'app_contacts_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            $sql = "INSERT INTO contacts (firstname, lastname, email) VALUES (:firstname, :lastname, :email)";
            $this->connection->executeQuery($sql, [
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
            ]);
    
            return $this->redirectToRoute('app_contacts');
        }
    
        return $this->render('contacts/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contacts/{id}', name: 'app_contact')]
    public function show(int $id): Response
    {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $contact = $this->connection->fetchAssociative($sql, ['id' => $id]);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found.');
        }

        return $this->render('contacts/show.html.twig', [
            'contact' => $contact,
        ]);
    }
}
