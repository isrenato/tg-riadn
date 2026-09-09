<?php

/**
 * Demo fixture for `vendor/bin/big0nia analyse tests/fixtures/big0nia`.
 * Not part of the real codebase or the PHPUnit suite — exists only to show
 * cases where big0nia does and doesn't complain.
 */

class User
{
    public function getId(): int
    {
        return 1;
    }
}

class Order
{
    public function getUserId(): int
    {
        return 1;
    }
}

class NestedLoopJoinDemo
{
    /**
     * Flagged: nested foreach join over two collections with no known small size.
     */
    public function flaggedForeachJoin(array $users, array $socks): void
    {
        foreach ($users as $user) {
            foreach ($socks as $sock) {
                if ($user->getId() === $sock->getUserId()) {
                    echo 'match';
                }
            }
        }
    }

    /**
     * Not flagged: same shape, but the inner collection is a small (<=5)
     * array literal, so big0nia suppresses it as provably cheap.
     */
    public function suppressedSmallInner(array $users): void
    {
        $orders = [new Order(), new Order(), new Order()];

        foreach ($users as $user) {
            foreach ($orders as $order) {
                if ($user->getId() === $order->getUserId()) {
                    echo 'match';
                }
            }
        }
    }

    /**
     * Flagged: canonical indexed for-loop version of the same join.
     */
    public function flaggedForLoopJoin(array $users, array $orders): void
    {
        for ($i = 0; $i < count($users); $i++) {
            for ($j = 0; $j < count($orders); $j++) {
                if ($users[$i]->getId() === $orders[$j]->getUserId()) {
                    echo 'match';
                }
            }
        }
    }

    /**
     * Flagged (new in 0.3.0): self-referential array_merge() rebuilding
     * $result from scratch on every iteration.
     */
    public function flaggedArrayMergeInLoop(array $items): array
    {
        $result = [];

        foreach ($items as $item) {
            $result = array_merge($result, [$item]);
        }

        return $result;
    }

    /**
     * Not flagged: same accumulation shape, but the loop provably iterates
     * a small (<=5) fixed array literal.
     */
    public function suppressedArrayMergeSmallLoop(): array
    {
        $result = [];
        $items = [1, 2, 3];

        foreach ($items as $item) {
            $result = array_merge($result, [$item]);
        }

        return $result;
    }

    /**
     * Not flagged: array_merge() builds an unrelated value — $combined
     * never appears as one of its own arguments, so it isn't a
     * self-referential accumulation.
     */
    public function unrelatedArrayMergeCall(array $defaults, array $overrides): array
    {
        $combined = [];

        foreach ($overrides as $key => $value) {
            $combined = array_merge($defaults, [$key => $value]);
        }

        return $combined;
    }
}
