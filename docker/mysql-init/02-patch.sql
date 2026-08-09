-- ---------------------------------------------------------------------------
-- Schema gaps in the production dump
--
-- 01-schema.sql (the bind-mounted u763116450_asTeeFinal.sql) predates three
-- things the application code depends on. Without them the payments screen and
-- checkout both fail with "column not found".
--
-- This patch exists only so the container runs against the legacy schema.
-- Phase 3 replaces the dump and this file with one authoritative migration set.
-- ---------------------------------------------------------------------------

-- orders.total  — written by UserController::confirmCheckout, read by
-- PaymentHistoryController::ordersIdAmount. Absent from both the dump and the
-- orders migration, but present in orders::$fillable.
ALTER TABLE `orders`
    ADD COLUMN IF NOT EXISTS `total` INT NOT NULL DEFAULT 0 AFTER `mop`;

-- orders.paid — read and written throughout PaymentHistoryController and
-- Traits/Filter.php as the strings 'paid' / 'not_paid'.
ALTER TABLE `orders`
    ADD COLUMN IF NOT EXISTS `paid` VARCHAR(20) NOT NULL DEFAULT 'not_paid' AFTER `total`;

-- payment_history — has a migration in the repo
-- (2024_06_10_061222_create_payment_history_table.php) but no table in the
-- dump. Columns mirror that migration exactly.
CREATE TABLE IF NOT EXISTS `payment_history` (
    `id`            BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `customers_id`  BIGINT UNSIGNED NOT NULL,
    `orders_id`     BIGINT UNSIGNED NOT NULL,
    `bank`          VARCHAR(255)    NOT NULL,
    `amount`        INT             NOT NULL,
    `proof`         VARCHAR(255)    NOT NULL,
    `created_at`    TIMESTAMP NULL DEFAULT NULL,
    `updated_at`    TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `payment_history_customers_id_foreign` (`customers_id`),
    KEY `payment_history_orders_id_foreign` (`orders_id`),
    CONSTRAINT `payment_history_customers_id_foreign`
        FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`),
    CONSTRAINT `payment_history_orders_id_foreign`
        FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
