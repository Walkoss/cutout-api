<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170623143808 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE catalog (id INT AUTO_INCREMENT NOT NULL, catalog_type_id INT NOT NULL, gender_type_id INT NOT NULL, provider_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_1B2C3247CAFE71BF (catalog_type_id), INDEX IDX_1B2C324737A4F92F (gender_type_id), INDEX IDX_1B2C3247A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalog_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F96BE75F77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6D1B16B377153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247CAFE71BF FOREIGN KEY (catalog_type_id) REFERENCES catalog_type (id)');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C324737A4F92F FOREIGN KEY (gender_type_id) REFERENCES gender_type (id)');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C3247A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C3247CAFE71BF');
        $this->addSql('ALTER TABLE catalog DROP FOREIGN KEY FK_1B2C324737A4F92F');
        $this->addSql('DROP TABLE catalog');
        $this->addSql('DROP TABLE catalog_type');
        $this->addSql('DROP TABLE gender_type');
    }
}
