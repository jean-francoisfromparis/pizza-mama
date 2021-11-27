<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211127113628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A4584665A');
        $this->addSql('DROP INDEX IDX_5F9E962A4584665A ON comments');
        $this->addSql('ALTER TABLE comments DROP created_at, CHANGE pseudo pseudo VARCHAR(50) NOT NULL, CHANGE product_id products_id INT NOT NULL, CHANGE rgpd compliance TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A6C8A81A9 FOREIGN KEY (products_id) REFERENCES Product (id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A6C8A81A9 ON comments (products_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A6C8A81A9');
        $this->addSql('DROP INDEX IDX_5F9E962A6C8A81A9 ON comments');
        $this->addSql('ALTER TABLE comments ADD created_at DATETIME NOT NULL, CHANGE pseudo pseudo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE products_id product_id INT NOT NULL, CHANGE compliance rgpd TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5F9E962A4584665A ON comments (product_id)');
    }
}
