<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration: Change place unique indexes from (city_id, slug), (city_id, name) to (slug).
 */
final class Version20200226191450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Change place unique indexes from (city_id, slug), (city_id, name) to (slug)';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP INDEX place_city_id_slug_idx');
        $this->addSql('DROP INDEX place_city_id_name_idx');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_741D53CD989D9B62 ON place (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('DROP INDEX UNIQ_741D53CD989D9B62');
        $this->addSql('CREATE UNIQUE INDEX place_city_id_slug_idx ON place (city_id, slug)');
        $this->addSql('CREATE UNIQUE INDEX place_city_id_name_idx ON place (city_id, name)');
    }
}
