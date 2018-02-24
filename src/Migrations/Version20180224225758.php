<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224225758 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fb_feed (id INT AUTO_INCREMENT NOT NULL, fb_page_id VARCHAR(50) NOT NULL, text LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, author VARCHAR(250) NOT NULL, count_likes INT DEFAULT 0 NOT NULL, count_comments INT DEFAULT 0 NOT NULL, created_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fb_comment (id INT AUTO_INCREMENT NOT NULL, fb_feed_id INT NOT NULL, message LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, created_time DATETIME NOT NULL, INDEX IDX_C8F8D91BD293774 (fb_feed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fb_comment ADD CONSTRAINT FK_C8F8D91BD293774 FOREIGN KEY (fb_feed_id) REFERENCES fb_feed (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fb_comment DROP FOREIGN KEY FK_C8F8D91BD293774');
        $this->addSql('DROP TABLE fb_feed');
        $this->addSql('DROP TABLE fb_comment');
    }
}
