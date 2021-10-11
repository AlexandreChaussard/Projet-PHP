<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011094203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, room_id, client_id, uuid, validated FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, client_id INTEGER NOT NULL, uuid VARCHAR(255) NOT NULL COLLATE BINARY, validated BOOLEAN NOT NULL, CONSTRAINT FK_42C8495554177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reservation (id, room_id, client_id, uuid, validated) SELECT id, room_id, client_id, uuid, validated FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary CLOB NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, capacity INTEGER NOT NULL, superficy INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL COLLATE BINARY, preview_image_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, ad_image_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_729F519B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name) SELECT id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id), CONSTRAINT FK_4E2C37B754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E2C37B798260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('DROP INDEX UNIQ_B9D87FBB54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailable_period AS SELECT id, room_id, start_date, end_date FROM unavailable_period');
        $this->addSql('DROP TABLE unavailable_period');
        $this->addSql('CREATE TABLE unavailable_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, CONSTRAINT FK_B9D87FBB54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO unavailable_period (id, room_id, start_date, end_date) SELECT id, room_id, start_date, end_date FROM __temp__unavailable_period');
        $this->addSql('DROP TABLE __temp__unavailable_period');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9D87FBB54177093 ON unavailable_period (room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_42C8495554177093');
        $this->addSql('DROP INDEX IDX_42C8495519EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reservation AS SELECT id, room_id, client_id, uuid, validated FROM reservation');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, client_id INTEGER NOT NULL, uuid VARCHAR(255) NOT NULL, validated BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO reservation (id, room_id, client_id, uuid, validated) SELECT id, room_id, client_id, uuid, validated FROM __temp__reservation');
        $this->addSql('DROP TABLE __temp__reservation');
        $this->addSql('CREATE INDEX IDX_42C8495554177093 ON reservation (room_id)');
        $this->addSql('CREATE INDEX IDX_42C8495519EB6921 ON reservation (client_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary CLOB NOT NULL, description CLOB NOT NULL, capacity INTEGER NOT NULL, superficy INTEGER NOT NULL, price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, preview_image_name VARCHAR(255) DEFAULT NULL, ad_image_name VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name) SELECT id, owner_id, summary, description, capacity, superficy, price, address, preview_image_name, ad_image_name FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id))');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
        $this->addSql('DROP INDEX UNIQ_B9D87FBB54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__unavailable_period AS SELECT id, room_id, start_date, end_date FROM unavailable_period');
        $this->addSql('DROP TABLE unavailable_period');
        $this->addSql('CREATE TABLE unavailable_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO unavailable_period (id, room_id, start_date, end_date) SELECT id, room_id, start_date, end_date FROM __temp__unavailable_period');
        $this->addSql('DROP TABLE __temp__unavailable_period');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B9D87FBB54177093 ON unavailable_period (room_id)');
    }
}
