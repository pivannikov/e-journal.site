<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211101161333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, number INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_faculty (course_id INT NOT NULL, faculty_id INT NOT NULL, INDEX IDX_1F5565AF591CC992 (course_id), INDEX IDX_1F5565AF680CAB68 (faculty_id), PRIMARY KEY(course_id, faculty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_faculty (discipline_id INT NOT NULL, faculty_id INT NOT NULL, INDEX IDX_7D5E001FA5522701 (discipline_id), INDEX IDX_7D5E001F680CAB68 (faculty_id), PRIMARY KEY(discipline_id, faculty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_faculty ADD CONSTRAINT FK_1F5565AF591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_faculty ADD CONSTRAINT FK_1F5565AF680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_faculty ADD CONSTRAINT FK_7D5E001FA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_faculty ADD CONSTRAINT FK_7D5E001F680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline ADD abbreviation VARCHAR(255) DEFAULT NULL, ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE `group` ADD course_id INT NOT NULL, ADD faculty_id INT NOT NULL');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE `group` ADD CONSTRAINT FK_6DC044C5680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5591CC992 ON `group` (course_id)');
        $this->addSql('CREATE INDEX IDX_6DC044C5680CAB68 ON `group` (faculty_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_faculty DROP FOREIGN KEY FK_1F5565AF591CC992');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5591CC992');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_faculty');
        $this->addSql('DROP TABLE discipline_faculty');
        $this->addSql('ALTER TABLE discipline DROP abbreviation, DROP description');
        $this->addSql('ALTER TABLE `group` DROP FOREIGN KEY FK_6DC044C5680CAB68');
        $this->addSql('DROP INDEX IDX_6DC044C5591CC992 ON `group`');
        $this->addSql('DROP INDEX IDX_6DC044C5680CAB68 ON `group`');
        $this->addSql('ALTER TABLE `group` DROP course_id, DROP faculty_id');
    }
}
