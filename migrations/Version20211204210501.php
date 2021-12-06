<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211204210501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A832C1C9');
        $this->addSql('DROP INDEX IDX_F5299398A832C1C9 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD email VARCHAR(255) NOT NULL, DROP email_id, CHANGE pseudo1 pseudo1 VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE order_line CHANGE product_name product_name VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE quantity quantity SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD email_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:ulid)\', DROP email, CHANGE pseudo1 pseudo1 VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A832C1C9 FOREIGN KEY (email_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398A832C1C9 ON `order` (email_id)');
        $this->addSql('ALTER TABLE order_line CHANGE product_name product_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE quantity quantity SMALLINT DEFAULT NULL');
    }
}
