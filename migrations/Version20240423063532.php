<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423063532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, is_correct TINYINT(1) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_group_level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, question_group_level_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_8ADC54D5BEA19221 (question_group_level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_users (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, question_group_id INT DEFAULT NULL, date DATE NOT NULL, INDEX IDX_E8F0DC69A76ED395 (user_id), INDEX IDX_E8F0DC699D5C694B (question_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5BEA19221 FOREIGN KEY (question_group_level_id) REFERENCES question_group_level (id)');
        $this->addSql('ALTER TABLE quiz_users ADD CONSTRAINT FK_E8F0DC69A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE quiz_users ADD CONSTRAINT FK_E8F0DC699D5C694B FOREIGN KEY (question_group_id) REFERENCES question_group_level (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5BEA19221');
        $this->addSql('ALTER TABLE quiz_users DROP FOREIGN KEY FK_E8F0DC69A76ED395');
        $this->addSql('ALTER TABLE quiz_users DROP FOREIGN KEY FK_E8F0DC699D5C694B');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question_group_level');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE quiz_users');
        $this->addSql('DROP TABLE users');
    }
}
