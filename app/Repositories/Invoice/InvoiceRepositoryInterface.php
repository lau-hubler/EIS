<?php


namespace App\Repositories\Invoice;

use App\Invoice;

interface InvoiceRepositoryInterface
{
    public function all();

    public function paginate();

    public function find($id);

    public function findAll($invoices);

    public function findAllByIds($ids);

    public function getIds($invoices = null);

    public function getOrdersOf($invoices);

    public function exportInvoices($invoices);

    public function exportOrders($invoices);
}
