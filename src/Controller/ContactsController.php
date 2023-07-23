<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactFormType;
use Doctrine\DBAL\Connection;
use App\Service\EmailLabs;

class ContactsController extends AbstractController
{
    private $connection;
    private $emailLabsService;

    public function __construct(Connection $connection, EmailLabs $emailLabsService)
    {
        $this->connection = $connection;
        $this->emailLabsService = $emailLabsService;
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
    public function show($id): Response
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

    #[Route('/contacts/{id}/edit', name: 'app_contact_edit')]
    public function edit(int $id, Request $request): Response
    {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $contact = $this->connection->fetchAssociative($sql, ['id' => $id]);

        if (!$contact) {
            throw $this->createNotFoundException('Contact not found.');
        }

        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $updateSql = "UPDATE contacts SET firstname = :firstname, lastname = :lastname, email = :email WHERE id = :id";
            $this->connection->executeStatement($updateSql, [
                'id' => $id,
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
            ]);

            return $this->redirectToRoute('app_contact', ['id' => $id]);
        }

        return $this->render('contacts/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/contacts/{id}/delete', name: 'app_contact_delete')]
    public function delete(int $id): Response
    {
        $sql = "SELECT * FROM contacts WHERE id = :id";
        $contact = $this->connection->fetchAssociative($sql, ['id' => $id]);

        if (!$contact) {
            throw $this->createNotFoundException('Kontakt nie został znaleziony.');
        }

        $deleteSql = "DELETE FROM contacts WHERE id = :id";
        $this->connection->executeStatement($deleteSql, ['id' => $id]);

        return $this->redirectToRoute('app_contacts');
    }

    #[Route('/contacts-send-emails', name: 'app_send_emails')]
    public function sendEmails(): Response
    {
        //TODO: Add possibility to send emails
        return $this->redirectToRoute('app_contacts');
    }
}
