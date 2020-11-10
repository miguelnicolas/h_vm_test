<?php

namespace App\Infrastructure\Storage;

interface StorageInterface
{
	public function count(string $dataset, $value): int;
	public function add(string $dataset, $value): bool;
	public function get(string $dataset, $value, int $qty): array;
	public function remove(string $dataset, $ids): void;
}