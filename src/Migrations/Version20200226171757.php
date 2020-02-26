<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration: CREATE TABLE: place
 */
final class Version20200226171757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'CREATE TABLE: place';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SEQUENCE place_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE place (
                    id INT NOT NULL, 
                    city_id INT NOT NULL, 
                    name VARCHAR(255) NOT NULL, 
                    active BOOLEAN DEFAULT \'true\' NOT NULL, 
                    closed BOOLEAN DEFAULT \'false\' NOT NULL, 
                    slug VARCHAR(255) NOT NULL, 
                    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
                    PRIMARY KEY(id)
                )'
        );
        $this->addSql('CREATE INDEX IDX_741D53CD8BAC62AF ON place (city_id)');
        $this->addSql('CREATE UNIQUE INDEX place_city_id_name_idx ON place (city_id, name)');
        $this->addSql('CREATE UNIQUE INDEX place_city_id_slug_idx ON place (city_id, slug)');
        $this->addSql('COMMENT ON COLUMN place.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql(
            'ALTER TABLE place ADD CONSTRAINT FK_741D53CD8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) 
                    NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP SEQUENCE place_id_seq CASCADE');
        $this->addSql('DROP TABLE place');
    }
}
