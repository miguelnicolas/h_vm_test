<?php

namespace App\Infrastructure\Storage;

interface StorageInterface
{
	public function count(string $dataset, $value): int;
	public function get(string $dataset, $value, int $qty): array;
	public function getAll(string $dataset): array;
	public function add(string $dataset, $value): bool;
	public function remove(string $dataset, $ids): void;
	public function flush(string $dataset): array;
}