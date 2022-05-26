<?php

namespace Collegeplannerpro\InterviewReport;

class Repository
{
    public \mysqli $db;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function allInvoices(): \mysqli_result
    {
        return $this->db->query(<<<SQL
            SELECT i.*, c.first_name, c.last_name,
            (SELECT SUM(amount) FROM payments p WHERE i.invoice_id = p.invoice_id) AS amount_paid
            FROM invoices i
            NATURAL JOIN contacts c
            ORDER BY i.issued_at
LIMIT 100  -- FIXME we need to be able to run this query without any LIMIT
SQL
        );
    }

    public function invoicePayments($invoiceId): \mysqli_result
    {
        return $this->db->query(
            "SELECT * FROM payments WHERE invoice_id = $invoiceId ORDER BY paid_at ASC"
        );
    }

    public function contactDetails(int $contactId): ?array
    {
        return $this->db->query(
            "SELECT * FROM contacts WHERE contact_id = $contactId LIMIT 1"
        )->fetch_assoc() ?: null;
    }
}
