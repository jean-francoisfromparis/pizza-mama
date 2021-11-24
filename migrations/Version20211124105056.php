<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124105056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, order_line_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', product_name VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, quantity SMALLINT DEFAULT NULL, INDEX IDX_9CE58EE1BB01DC09 (order_line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1BB01DC09 FOREIGN KEY (order_line_id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_line');
    }
}
