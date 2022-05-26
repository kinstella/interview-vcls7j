<?php

namespace Collegeplannerpro\InterviewReport;

use Twig\Environment;

class Controller
{
    private Repository $repository;
    private Environment $twig;

    public function __construct(Gettable $services)
    {
        $this->repository = $services->get('repository');
        $this->twig = $services->get('twig');
    }

    public function home(Gettable $routeMatches): string
    {
        return $this->twig->render('home.html.twig');
    }

    public function paymentsReport(Gettable $routeMatches): string
    {
        $invoiceResult = $this->repository->allInvoices();
        $invoices = [];

        while ($invoice = $invoiceResult->fetch_assoc()) {
            $invoice['payments'] = $this->repository->invoicePayments($invoice['invoice_id'])->fetch_all(MYSQLI_ASSOC);
            $invoices[] = $invoice;
        }

        return $this->twig->render('paymentsReport.html.twig', [
            'invoices' => $invoices,
        ]);
    }

    public function contactDetails(Gettable $routeMatches): string
    {
        $contactId = intval($routeMatches->get('contactId'));

        if (!$contactId) {
            http_response_code(400);
            exit();
        }

        $contactDetails = $this->repository->contactDetails($contactId);

        if (!$contactDetails) {
            http_response_code(404);
            exit();
        }

        return $this->twig->render('contactDetails.html.twig', ['contact' => $contactDetails]);
    }
}
