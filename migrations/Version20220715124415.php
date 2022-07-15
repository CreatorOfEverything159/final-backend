<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715124415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649d060a723');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649d794ef7a');
        $this->addSql('DROP SEQUENCE flight_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ticket_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_role_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE teacher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, knowledge_level VARCHAR(255) NOT NULL, lesson VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, lessons_group_id INT DEFAULT NULL, teacher_id INT NOT NULL, start_time VARCHAR(255) NOT NULL, end_time VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F3E1D690F3 ON lesson (lessons_group_id)');
        $this->addSql('CREATE INDEX IDX_F87474F341807E1D ON lesson (teacher_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, my_group_id INT NOT NULL, fio VARCHAR(255) NOT NULL, date_of_birth VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF33CC064C08 ON student (my_group_id)');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, subject_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subject_teacher (subject_id INT NOT NULL, teacher_id INT NOT NULL, PRIMARY KEY(subject_id, teacher_id))');
        $this->addSql('CREATE INDEX IDX_15740A7723EDC87 ON subject_teacher (subject_id)');
        $this->addSql('CREATE INDEX IDX_15740A7741807E1D ON subject_teacher (teacher_id)');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, fio VARCHAR(255) NOT NULL, experience VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3E1D690F3 FOREIGN KEY (lessons_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33CC064C08 FOREIGN KEY (my_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_teacher ADD CONSTRAINT FK_15740A7723EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject_teacher ADD CONSTRAINT FK_15740A7741807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE airport_city');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP INDEX idx_8d93d649d794ef7a');
        $this->addSql('DROP INDEX uniq_8d93d649d060a723');
        $this->addSql('DROP INDEX uniq_8d93d649aa08cb10');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP userroleid');
        $this->addSql('ALTER TABLE "user" DROP passengerpassport');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN login TO username');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F3E1D690F3');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF33CC064C08');
        $this->addSql('ALTER TABLE subject_teacher DROP CONSTRAINT FK_15740A7723EDC87');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F341807E1D');
        $this->addSql('ALTER TABLE subject_teacher DROP CONSTRAINT FK_15740A7741807E1D');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE teacher_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE flight_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ticket_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE airport_city (airport VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, PRIMARY KEY(airport))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, number VARCHAR(6) NOT NULL, departure_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, departure_airport VARCHAR(255) NOT NULL, destination_airport VARCHAR(255) NOT NULL, seats_amount INT NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ticket (id INT NOT NULL, flight_id INT NOT NULL, passenger_passport VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE passenger (passport VARCHAR(10) NOT NULL, fio VARCHAR(255) NOT NULL, PRIMARY KEY(passport))');
        $this->addSql('CREATE TABLE user_role (id INT NOT NULL, role VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_2de8c6a357698a6a ON user_role (role)');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE subject_teacher');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677');
        $this->addSql('ALTER TABLE "user" ADD userroleid INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD passengerpassport VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" DROP password');
        $this->addSql('ALTER TABLE "user" RENAME COLUMN username TO login');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649d794ef7a FOREIGN KEY (userroleid) REFERENCES user_role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649d060a723 FOREIGN KEY (passengerpassport) REFERENCES passenger (passport) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d649d794ef7a ON "user" (userroleid)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649d060a723 ON "user" (passengerpassport)');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649aa08cb10 ON "user" (login)');
    }
}
