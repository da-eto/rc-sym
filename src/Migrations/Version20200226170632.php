<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration: CREATE TABLE: city
 */
final class Version20200226170632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'CREATE TABLE: city';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(
            'CREATE TABLE city (
                id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                PRIMARY KEY(id)
            )'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B02345E237E06 ON city (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D5B0234989D9B62 ON city (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('DROP TABLE city');
    }
}
