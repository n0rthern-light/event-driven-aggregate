<?php

namespace Nlf\Component\Event\Aggregate\Transaction;

interface TransactionInterface
{
    public function begin(): void;
    public function commit(): void;
    public function rollback(): void;
}